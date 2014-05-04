<?hh //strict
namespace HackUnit\Runner;

use HackUnit\Core\TestCase;

class OptionsTest extends TestCase
{
    public function test_getExcludedPaths_splits_set_string_into_set(): void
    {
        $options = new Options();
        $options->setExcludedPaths("path/to/excluded1 path/to/excluded2");
        $excluded = $options->getExcludedPaths();

        $this->expect($excluded->contains('path/to/excluded1'))->toEqual(true);
        $this->expect($excluded->contains('path/to/excluded2'))->toEqual(true);
    }
}
