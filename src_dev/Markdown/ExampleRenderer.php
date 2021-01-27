<?php

namespace Terminal\Dev\Markdown;

const REGEX = '#^```terminal\((\d+),(\d+)\)$#';

class ExampleRenderer
{
    private ?string $currentDirectory = null;
    private ?string $currentBase = null;
    private int $counter = 0;

    public function render(string $file): void
    {
        $this->counter = 0;
        $this->currentDirectory = dirname($file);
        $this->currentBase = substr(basename($file), 0, -3);
        $content = file_get_contents($file);
        $isTerminalCode = false;
        $lines = null;
        $rendered = null;
        $columns = null;
        $code = null;

        $exploded = explode("\n", rtrim($content, "\n"));
        $output = "";

        foreach ($exploded as $line) {
            // Start of Terminal block code
            if (false === $isTerminalCode && preg_match(REGEX, $line, $matches)) {
                    $isTerminalCode = true;
                    [, $lines, $columns] = $matches;
            } elseif (true === $isTerminalCode && $line === '```') {
                $isTerminalCode = false;
                $rendered = $this->doRender($code, $lines, $columns);
                $code = '';
                $lines = null;
                $columns = null;
            } elseif (true === $isTerminalCode) {
                $code .= $line."\n";
            } elseif ($rendered !== null) {
                $output .= $rendered."\n";
                $rendered = null;
                if (str_starts_with($line, '![')) {
                    continue;
                }
            }

            $output .= $line."\n";
        }

        if ($rendered !== null) {
            $output .= $rendered."\n";
        }

        file_put_contents($file, $output);
    }

    private function doRender(string $code, int $lines, int $columns): string
    {
        $relativePath = '_examples/'.$this->currentBase.'_'.$this->counter.'.gif';
        $path = $this->currentDirectory.'/'.$relativePath;
        echo $path;
        $this->counter++;


        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        touch($path);
        /*
        $file = tempnam(sys_get_temp_dir(), 'term_');
        file_put_contents($file, '<?php require_once "'.__DIR__.'/../../vendor/autoload.php"; $terminal = new Terminal\Terminal(); '.$code);
        exec('terminalizer record -k -d "php '.$file.'" /tmp/out.yml');
        echo " - recorded";
        exec('terminalizer render -o '.$path.' /tmp/out.yml');
        echo ", rendered\n";
        unlink('/tmp/out.yml');
        unlink($file);
        */

        return '<!-- [Video capture of code above]('.$relativePath.') -->';
    }
}
