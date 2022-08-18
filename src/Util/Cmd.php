<?php

namespace Feierstoff\CommandBundle\Util;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Cmd extends Command {

    private readonly Filesystem $file;
    private SymfonyStyle $io;
    private string $projectDir;

    public function __construct() {
        parent::__construct();
        $this->file = new Filesystem();
    }

    protected function bash(string $command): void {
        $process = Process::fromShellCommandline($command);
        $process->setTty(true);

        $process->run(function ($type, $buffer) {
            echo $buffer;
        });

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    protected function batch(array $commands): void {
        foreach ($commands as $command) {
            $this->bash($command);
        }
    }

    protected function bootstrap(string $target): void {
        $init = explode(".init", $target);

        if (sizeof($init) > 1) {
            $this->file->copy(Path::makeAbsolute("../../bootstrap/" . $target, $this->projectDir), $init[0], true);
        } else {
            $this->file->copy(Path::makeAbsolute("../../bootstrap/" . $target, $this->projectDir), $target, true);
        }
    }

    protected function getBundleRoot(): string {
        return Path::makeAbsolute("../../", $this->projectDir);
    }

    protected function initExecution(InputInterface $input, OutputInterface $output, string $dir) {
        $this->io = new SymfonyStyle($input, $output);
        $this->projectDir = $dir;
    }

    protected function write(string $line = "") {
        $this->io->writeln($line);
    }

    protected function success(string $line = "") {
        $this->io->success($line);
    }

    protected function info(string $line = "") {
        $this->io->info($line);
    }

    protected function error(string $line = "") {
        $this->io->error($line);
    }

    protected function warning(string $line = "") {
        $this->io->warning($line);
    }

    protected function askYesNo(string $question, ?callable $callbackYes = null, ?callable $callbackNo = null): void {
        $answer = $this->io->ask($question);
        if (strtolower($answer[0]) == "y" && $callbackYes) {
            call_user_func($callbackYes);
        }

        if (strtolower($answer[0]) == "n" && $callbackNo) {
            call_user_func($callbackNo);
        }
    }

    protected function IO(): SymfonyStyle {
        return $this->io;
    }

}