<?php

namespace FrankDeJonge\CommandIdCorrelation;

interface CommandHandler
{
    public function handle(Command $command): void;
}
