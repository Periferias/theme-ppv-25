<?php 
use MapasCulturais\i;
 
$this->import('
    create-opportunity 
    search 
    search-filter-opportunity
    search-list
    search-map
    mc-tabs
    mc-tab
    opportunity-table
');

// $this->breadcrumb = [
//     ['label'=> i::__('Inicio'), 'url' => $app->createUrl('site', 'index')],
//     ['label'=> i::__('Oportunidades'), 'url' => $app->createUrl('opportunities')],
// ];
?>
<div class="tabs-component__panels">
    <div class="search__tabs--list">
        <search-list :pseudo-query="pseudoQuery" type="opportunity" select="name,type,shortDescription,files.avatar,seals,terms,registrationFrom,registrationTo,hasEndDate,isContinuousFlow">
            <template #filter>
                

                <search-filter-opportunity :pseudo-query="pseudoQuery"></search-filter-opportunity>
            </template>
        </search-list>
    </div>
</div>
