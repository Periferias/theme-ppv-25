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
    home-header 
    opportunity-table
');
?>

<home-header></home-header>

<search page-title="<?= htmlspecialchars($this->text('title', i::__('Oportunidades'))) ?>" entity-type="opportunity" :initial-pseudo-query="{type:[],'term:area':[]}"> 
    <template #default="{pseudoQuery, entity}">
        <mc-tabs class="search__tabs" sync-hash>
            <mc-tab icon="list" label="<?php i::esc_attr_e('Lista') ?>" slug="list">
                <div class="tabs-component__panels">
                    <div class="search__tabs--list">
                        <search-list :pseudo-query="pseudoQuery" type="opportunity" select="name,type,shortDescription,files.avatar,seals,terms,registrationFrom,registrationTo,hasEndDate,isContinuousFlow">
                        </search-list>
                    </div>
                </div>
            </mc-tab>
        </mc-tabs>
    </template>
</search>