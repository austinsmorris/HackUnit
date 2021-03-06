<?hh //strict
namespace HackPack\HackUnit\Tests\Core;

use HackPack\HackUnit\Core\ExpectationException;
use HackPack\HackUnit\Core\CallableExpectation;
use HackPack\HackUnit\Core\TestCase;

class CallableExpectationTest extends TestCase
{
    protected ?(function(): void) $callable;

    <<Override>> public function setUp(): void
    {
        $this->callable = $fun = () ==> {throw new ExpectationException('unexpected!');};
    }

    public function test_toThrow_does_nothing_if_exception_thrown(): void
    {
        if ($this->callable) {
            $this->expectCallable($this->callable)->toThrow('\HackPack\HackUnit\Core\ExpectationException');
        }
    }

    public function test_toThrow_throws_exception_if_wrong_exception_type(): void
    {
        if ($this->callable) {
            $this->expectCallable(() ==> {
                $expectation = new CallableExpectation($this->callable);
                $expectation->toThrow('\RuntimeException');
            })->toThrow('\HackPack\HackUnit\Core\ExpectationException');
        }
    }

    public function test_toThrow_throws_exception_if_no_exception_thrown(): void
    {
        $this->expectCallable(() ==> {
            $callable = () ==> { $var = 'do nothing';  };
            $expectation = new CallableExpectation($callable);
            $expectation->toThrow('\RuntimeException');
        })->toThrow('\HackPack\HackUnit\Core\ExpectationException');
    }

    public function test_toNotThrow_does_nothing_if_exception_not_thrown(): void
    {
        $callable = () ==> { $var = 'do nothing'; };
        $expectation = new CallableExpectation($callable);
        $expectation->toNotThrow();
    }
    
    public function test_toNotThrow_throws_exception_if_exception_thrown(): void
    {
        if ($this->callable) {
            $fun = () ==> { $fn = $this->callable; $fn();};
            $this->expectCallable($fun)->toThrow('\HackPack\HackUnit\Core\ExpectationException');
        }
    }
}
