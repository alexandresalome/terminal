<?php

namespace Terminal\Terminfo;

# https://www.gnu.org/software/termutils/manual/termcap-1.3/html_mono/termcap.html#SEC23

/**
 * Extract capabilities from Terminfo database (if available).
 */
class Finder
{
    private static array $searchLocations = [
        '/usr/lib/terminfo',
        '/usr/share/terminfo',
    ];

    public function guess(): Capabilities
    {
        $term = getenv('TERM');
        if (!$term) {
            throw new \RuntimeException('No environment variable TERM found.');
        }

        foreach (self::$searchLocations as $location) {
            $files = [
                $location.'/'.$term[0].'/'.$term,
                $location.'/'.$term,
            ];

            foreach ($files as $file) {
                if (is_file($file)) {
                    $reader = new FileReader();

                    return $reader->readFile($file);
                }
            }
        }

        throw new \RuntimeException(sprintf(
            'Terminal "%s" not found (searched in %s).',
            $term,
            '"'.implode('", "', self::$searchLocations).'"'
        ));
    }
}
