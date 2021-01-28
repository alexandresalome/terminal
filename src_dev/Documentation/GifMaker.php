<?php

namespace Terminal\Dev\Documentation;

use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;
use Terminal\Dev\Output\TestOutput;
use Terminal\Terminal;
use Terminal\Terminfo\Finder;

const REGEX = '/^# Terminal \((\d+),(\d+)(?:,(-?\d+))?\)$/';

const TERMINALIZER_CONFIG = [
    'cols' => 80,
    'rows' => 5,
    'repeat' => 0,
    'quality' => 100,
    'frameDelay' => 'auto',
    'maxIdleTime' => 2000,
    'frameBox' => [
        'type' => null,
        'style' => [
            'margin' => '0',
            'border' => '1px solid #afafaf',
            'padding' => '10px',
            'backgroundColor' => '#232628',
        ],
    ],
    'watermark' => [
        'imagePath' => null,
        'style' => [
            'position' => 'absolute',
            'right' => '15px',
            'bottom' => '15px',
            'width' => '100px',
            'opacity' => 0.9,
        ],
    ],
    'cursorStyle' => 'block',
    'fontFamily' => 'Monaco, Lucida Console, Ubuntu Mono, Monospace',
    'fontSize' => 18,
    'lineHeight' => 1,
    'letterSpacing' => 0,
    'theme' => [
        'background' => 'transparent',
        'foreground' => '#afafaf',
        'cursor' => '#c7c7c7',
        'black' => '#232628',
        'red' => '#fc4384',
        'green' => '#b3e33b',
        'yellow' => '#ffa727',
        'blue' => '#75dff2',
        'magenta' => '#ae89fe',
        'cyan' => '#708387',
        'white' => '#d5d5d0',
        'brightBlack' => '#626566',
        'brightRed' => '#ff7fac',
        'brightGreen' => '#c8ed71',
        'brightYellow' => '#ebdf86',
        'brightBlue' => '#75dff2',
        'brightMagenta' => '#ae89fe',
        'brightCyan' => '#b1c6ca',
        'brightWhite' => '#f9f9f4',
    ],
];

class GifMaker
{
    private string $documentationDirectory;
    private string $gifDirectoryName;

    public function __construct(string $documentationDirectory, string $relativeGifDirectory)
    {
        $this->documentationDirectory = rtrim($documentationDirectory, '/');
        $this->gifDirectoryName = trim($relativeGifDirectory, '/');
    }

    public function makeGifs(string $file): void
    {
        if (!str_starts_with($file, $this->documentationDirectory . '/')) {
            throw new \InvalidArgumentException(sprintf(
                'File "%s" not in "%s".',
                $file,
                $this->documentationDirectory
            ));
        }

        $relative = trim(substr($file, strlen($this->documentationDirectory) + 1), '/');
        $name = substr(basename($relative), 0, -3);
        $dirname = dirname($relative) === '.' ? '' : dirname($relative).'/';
        $relativePath = $this->gifDirectoryName.'/'.$name;
        $absolutePath = $this->documentationDirectory.'/'.$dirname.$relativePath;
        $content = file_get_contents($file);
        $lines = explode("\n", rtrim($content, "\n"));
        $lines = $this->insertInMarkdown($lines, $absolutePath, $relativePath);
        $outcome = implode("\n", $lines)."\n";
        if ($content !== $outcome) {
            file_put_contents($file, $outcome);
        }
    }

    private function insertInMarkdown(array $lines, string $absolutePath, string $relativePath): array
    {
        $counter = 0;
        $isCode = false;
        $pending = [];
        $image = null;
        $output = [];
        foreach ($lines as $line) {

            if ($image !== null) {
                $output[] = $image;
                $image = null;

                if (str_starts_with($line, '![')) {
                    continue;
                }
            }

            $output[] = $line;

            if ($line === '```') {
                $isCode = !$isCode;
                if ($isCode) {
                    continue;
                }

                if (!count($pending) || !$this->isTerminalCode($pending)) {
                    $pending = [];

                    continue;
                }

                $image = $this->renderTerminalCode($pending, $absolutePath.'.'.$counter, $relativePath.'.'.$counter);
                $counter++;
                $pending = [];

                continue;
            }

            if ($isCode) {
                $pending[] = $line;
            }
        }

        return $output;
    }

    private function isTerminalCode(array $lines): bool
    {
        return isset($lines[0]) && preg_match(REGEX, $lines[0]);
    }

    private function renderTerminalCode(array $lines, string $absolutePath, string $relativePath): string
    {
        $relativeGifFile = $relativePath.'.gif';
        $absoluteGifPath = $absolutePath.'.gif';
        $sumFile = $absolutePath.'.sum';

        $title = substr($absoluteGifPath, strlen($this->documentationDirectory) + 1);
        $dir = dirname($absoluteGifPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        preg_match(REGEX, $lines[0], $matches);
        $rows = (int) $matches[1];
        $cols = (int) $matches[2];
        $repeat = (int) ($matches[3] ?? -1);

        $records = $this->getRecords(array_splice($lines, 1));

        $sum = file_exists($sumFile) ? file_get_contents($sumFile) : '';
        $actualSum = sha1(json_encode([
            TERMINALIZER_CONFIG,
            $records,
            $cols,
            $rows,
            $repeat,
        ], JSON_THROW_ON_ERROR));
        $returnValue = '![Video capture of code above]('.$relativeGifFile.')';

        if ($actualSum === $sum && file_exists($absoluteGifPath)) {
            echo "HIT  - $title\n";

            return $returnValue;
        }

        echo "MISS - $title\n";

        // Render
        $this->renderWithTerminalizer($records, $absoluteGifPath, $cols, $rows, $repeat);

        file_put_contents($sumFile, $actualSum);

        return $returnValue;
    }

    private function renderWithTerminalizer(array $data, string $absoluteGifPath, int $cols, int $rows, int $repeat): void
    {
        $result = [
            'config' => array_merge(
                TERMINALIZER_CONFIG,
                ['cols' => $cols, 'rows' => $rows, 'repeat' => $repeat],
            ),
            'records' => [],
        ];

        $buffer = '';
        $delay = 0;

        foreach ($data as $row) {
            $type = $row[0];
            $value = $row[1] ?? null;

            if ($type === 'wait') {
                if ($buffer !== '') {
                    $result['records'][] = [
                        'delay' => $delay,
                        'content' => str_replace("\n", "\r\n", $buffer),
                    ];

                    $buffer = '';
                }
                $delay += $value;

                continue;
            }

            if ($type === 'write') {
                $buffer .= $value;

                continue;
            }

            if ($type === 'flush' && $buffer !== '' && $delay !== 0) {
                $result['records'][] = [
                    'delay' => $delay,
                    'content' => str_replace("\n", "\r\n", $buffer),
                ];

                $buffer = '';
                $delay = 0;
            }
        }

        if ($buffer !== '') {
            $result['records'][] = [
                'delay' => $delay,
                'content' => str_replace("\n", "\r\n", $buffer),
            ];
        }

        $yamlFile = tempnam(sys_get_temp_dir(), 'term_');
        unlink($yamlFile);
        $yamlFile .= '.yml';

        file_put_contents($yamlFile, Yaml::dump($result));
        $yamlBasename = basename($yamlFile);
        $yamlDirname = dirname($yamlFile);
        try {
            $process = new Process(['terminalizer', 'render', '-o', $absoluteGifPath, $yamlBasename]);
            $process->setWorkingDirectory($yamlDirname);
            $process->setTimeout(null);
            $process->setTty(true);
            $process->setPty(true);
            $process->mustRun();
            echo "\n\n";
        } finally {
            unlink($yamlFile);
        }
    }

    private function getRecords(array $code): array
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'term_');
        file_put_contents($tmpFile, '<?php '.implode("\n", $code));
        $output = new TestOutput();

        try {
            $capabilities = (new Finder())->guess();
            $terminal = new Terminal($capabilities, $output);
            require $tmpFile;

            return $output->getTestRecords();
        } finally {
            unlink($tmpFile);
        }
    }
}
