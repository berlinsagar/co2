<?php

namespace Services;

class Application
{

    protected $dbService;
    protected $recordFinderService;
    protected $recordAddService;

    public function setDBService(DBService $dBService)
    {
        $this->dbService = $dBService;
    }

    public function getDBService(): DBService
    {
        return $this->dbService;
    }

    public function setRecordFinderService(RecordFinderService $recordFinderService)
    {
        $this->recordFinderService = $recordFinderService;
    }

    public function getRecordFinderService(): RecordFinderService
    {
        return $this->recordFinderService;
    }

    public function setRecordAddService(RecordAddService $recordAddService)
    {
        $this->recordAddService = $recordAddService;
    }

    public function getRecordAddService(): RecordAddService
    {
        return $this->recordAddService;
    }
}
