<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
;

class ResourceController extends Controller
{
    
    public function governance() {

        $cmr = new ResourcePack('Competition Manual and Rules');
        $cmr->add('BULSCA COVID-19 Guidance (Sept 2021)');
        $cmr->add('BULSCA Championships Rules 2022');
        $cmr->add('RLSS Speeds Rules 2020');
        $cmr->add('CM 2021 - Part 1 - Manual');
        $cmr->add('CM 2021 - Part 2 - Events');
        $cmr->add('CM 2021 - Part 3 - Disqualification and Penalty Codes');
        $cmr->add('CM 2021 - Part 4 - Forms');
        $cmr->add('RLSS Nationals Rules 2018');
        
        $og = new ResourcePack('Other Governance');
        $og->add('Constitution v2.5');
        $og->add('Judges Panel Guidelines V2.2');
        $og->add('Online Voting Procedures');
        $og->add('Disciplinary Procedure V1.3');
        $og->add('Competition Finance Pack');
        $og->add('League Competition Application Pack (2021-22)');
        $og->add('Calculation of Results');
        $og->add('Alterations for First Competition of Season');
        $og->add('Officiating Pathway');
        $og->add('SERC Writing Guidelines v2.0');
        $og->add('Procedures for Dealing with Proposals v1.0');
        $og->add('Competition Allocation Policy');

        $oc = new ResourcePack('Organising a Competition');
        $oc->add('Competition Scoresheet v17.3 - Blank');
        $oc->add('Competition Speeds - Lane Template');
        $oc->add('Competition Speeds - Chief Template');
        $oc->add('SERC Setter and Judges Allocation Guidelines');
        $oc->add('Competition Finance Pack');
        $oc->add('Competition Preparation Gantt Chart');
        $oc->add('Competition Day Gantt Chart');
        $oc->add('Competition Checklist');
        $oc->add('Quick Guide to Scoring');
        $oc->add('Judge Allocation Sheet');
        $oc->add('Organising Officials');

        $res = [
            $cmr->bundle(),
            $og->bundle(),
            $oc->bundle()
        ];

        return view('resources.governance', ['res' => $res]);
    }

    public function get($id) {
        
    }

}


class ResourcePack {

    private $resources = [];
    private $name;
    private $count = 1;

    public function __construct($name) {
        $this->name = $name;

    }

    public function add($name) {
        array_push($this->resources, [
            'name' => $name,
            'id' => $this->count
        ]);
        $this->count++;
    }

    public function bundle() {
        return [
            'name' => $this->name,
            'resources' => $this->resources
        ];
    }



}
