<?php
App::uses('AppController', 'Controller');

class UtmController extends AppController {
    public $uses = ['UtmData'];
    public $components = ['Paginator'];
    public $helpers = ['Html', 'Form', 'Paginator'];

    public function list() {
        // Paginate sources
        $sources = $this->Paginator->paginate(
            'UtmData',
            [], // conditions
            [
                'fields' => ['DISTINCT UtmData.source'],
                'limit'  => 20,
                'order'  => ['UtmData.source' => 'ASC']
            ]
        );

        $sourceList = array_map(function($s) { return $s['UtmData']['source']; }, $sources);

        if (empty($sourceList)) {
            $nestedData = [];
        } else {
            $placeholders = "'" . implode("','", $sourceList) . "'";
            $results = $this->UtmData->query("
            SELECT source, medium, campaign, content, GROUP_CONCAT(term) AS terms
            FROM utm_data
            WHERE source IN ($placeholders)
            GROUP BY source, medium, campaign, content
            ORDER BY source, medium, campaign, content
        ");

            $nestedData = [];
            foreach ($results as $row) {
                $source  = $row['utm_data']['source'];
                $medium  = $row['utm_data']['medium'] ?? 'NULL';
                $campaign= $row['utm_data']['campaign'] ?? 'NULL';
                $content = $row['utm_data']['content'] ?? 'NULL';
                $terms   = isset($row[0]['terms']) ? explode(',', $row[0]['terms']) : ['NULL'];

                if (!isset($nestedData[$source])) $nestedData[$source] = [];
                if (!isset($nestedData[$source][$medium])) $nestedData[$source][$medium] = [];
                if (!isset($nestedData[$source][$medium][$campaign])) $nestedData[$source][$medium][$campaign] = [];
                $nestedData[$source][$medium][$campaign][$content] = $terms;
            }
        }

        $this->set(compact('nestedData'));
    }    
}