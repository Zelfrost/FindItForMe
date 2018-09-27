<?php

class Database
{
    const DATABASE_PATH = __DIR__.'/../base';

    public function offerAlreadyExist($identifier)
    {
        exec("grep '$identifier' base|wc -l", $output);

        return 0 !== (int) $output[0];
    }

    public function putOffer($identifier)
    {
        file_put_contents(self::DATABASE_PATH, "$identifier\n", FILE_APPEND);
    }
}