<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Alias;

class AliasTest extends TestCase
{
    public function test_resolves_command_with_defaults()
    {
        $alias = new Alias();
        $alias->command = 'echo {$MSG}';
        $alias->parameters = ['MSG' => 'Hello'];

        $this->assertEquals('echo Hello', $alias->resolveCommand([]));
    }

    public function test_resolves_command_with_overrides()
    {
        $alias = new Alias();
        $alias->command = 'echo {$MSG}';
        $alias->parameters = ['MSG' => 'Hello'];

        // Test lowercase input override
        $this->assertEquals('echo World', $alias->resolveCommand(['msg' => 'World']));
    }

    public function test_resolves_mixed_case_variables()
    {
        $alias = new Alias();
        $alias->command = 'cargo --tag v{$TaG}';
        $alias->parameters = ['TAG' => 'latest'];

        $this->assertEquals('cargo --tag vlatest', $alias->resolveCommand([]));
        $this->assertEquals('cargo --tag v1.0', $alias->resolveCommand(['tag' => '1.0']));
    }

    public function test_ignores_unknown_variables()
    {
        $alias = new Alias();
        $alias->command = 'echo {$FOO}';
        // No params
        $this->assertEquals('echo {$FOO}', $alias->resolveCommand([]));
    }
}
