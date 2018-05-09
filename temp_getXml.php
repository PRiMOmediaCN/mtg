<?php
$xml2='<?xml version="1.0" encoding="UTF-8"?>
    <section id="main">
        <item id="Glint-Nest Crane">
            <card set="KLD" lang="CS" count="4"/>
        </item>
        <item id="Krark-Clan Ironworks">
            <card set="FD" lang="CS" count="4"/>
        </item>
        <item id="Sword of the Meek">
            <card set="FUT" lang="CS" count="4"/>
        </item>
        <item id="Thopter Foundry">
            <card set="ARB" lang="CS" count="4"/>
        </item>
        <item id="Welding Jar">
            <card set="MR" lang="CS" count="1"/>
        </item>
        <item id="Serum Visions">
            <card set="FD" lang="CS" count="4"/>
        </item>
        <item id="Ancient Stirrings">
            <card set="ROE" lang="CS" count="4"/>
        </item>
        <item id="Mox Opal">
            <card set="SOM" lang="CS" count="4"/>
        </item>
        <item id="Mishra\'s Bauble">
            <card set="CS" lang="CS" count="4"/>
        </item>
        <item id="Whir of Invention">
            <card set="AER" lang="CS" count="4"/>
        </item>
        <item id="Ensnaring Bridge">
            <card set="8E" lang="CS" count="4"/>
        </item>
        <item id="Pyrite Spellbomb">
            <card set="MR" lang="CS" count="1"/>
        </item>
        <item id="Academy Ruins">
            <card set="TSP" lang="CS" count="1"/>
        </item>
        <item id="Botanical Sanctum">
            <card set="KLD" lang="CS" count="3"/>
        </item>
        <item id="Darkslick Shores">
            <card set="SOM" lang="CS" count="3"/>
        </item>
        <item id="Glimmervoid">
            <card set="MR" lang="CS" count="4"/>
        </item>
        <item id="Inventors\' Fair">
            <card set="KLD" lang="CS" count="1"/>
        </item>
        <item id="Island">
            <card set="XLN" lang="CS" ver="1" count="1"/>
        </item>
        <item id="River of Tears">
            <card set="FUT" lang="CS" count="1"/>
        </item>
        <item id="Spire of Industry">
            <card set="AER" lang="CS" count="4"/>
        </item>
    </section>';

$xml='<?xml version="1.0" encoding="UTF-8"?>
    <section id="main">
        <item id="Fatal Push">
            <card set="AER" lang="CS" count="4"/>
        </item>
        <item id="Grafdigger\'s Cage">
            <card set="DKA" lang="CS" count="3"/>
        </item>
        <item id="Defense Grid">
            <card set="9E" lang="CS" count="1"/>
        </item>
        <item id="Abrupt Decay">
            <card set="RTR" lang="CS" count="4"/>
        </item>
        <item id="Collective Brutality">
            <card set="EMN" lang="CS" count="3"/>
        </item>
    </section>';
function xmlToArray($xml){    
	libxml_disable_entity_loader(true);
	$values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);        
	return $values;
}

$xml_arr=xmlToArray($xml);
foreach($xml_arr['item'] as $list){
	//print_r($list['card']['@attributes']['count']);
	echo $list['card']['@attributes']['count'].' '.$list['@attributes']['id'].'<br>';
}
?>