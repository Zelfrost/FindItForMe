<?php

class Database
{
    private $databasePath;

    public function __construct()
    {
        $this->databasePath = Config::getBaseFile();
    }

    public function offerAlreadyExist($identifier)
    {
        exec(sprintf('grep "%s" %s|wc -l', $identifier, $this->databasePath), $output);

        return 0 !== (int) $output[0];
    }

    public function putOffer($identifier)
    {
        file_put_contents($this->databasePath, "$identifier\n", FILE_APPEND);
    }
}