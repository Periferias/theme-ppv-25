<?php $this->applyTemplateHook('registration-field-item', 'begin') ?>
<div ng-if="field.fieldType !== 'file' && field.fieldType !== 'section' && field.fieldType !== 'persons' && field.config.entityField !== '@location' && field.config.entityField !== '@links' && field.fieldType !== 'links' && !checkRegistrationFields(field, 'links') && field.fieldType !== 'url'">
    <label>{{field.required ? '*' : ''}} {{field.title}}: </label>
    <div ng-if="field.fieldType !== 'agent-owner-field'">
        <span ng-if="entity[field.fieldName] && field.fieldType !== 'textarea'">
            <span ng-bind-html="printField(field, entity[field.fieldName]) === 'Não' ? 'Sim' : printField(field, entity[field.fieldName])"></span>
        </span>
        <p ng-if="entity[field.fieldName] && field.fieldType === 'textarea'" ng-bind-html="printField(field, entity[field.fieldName])" style="white-space: pre-line"></p>
        <span ng-if="!entity[field.fieldName]"><em><?php \MapasCulturais\i::_e("Campo não informado."); ?></em></span>
    </div>

    <div ng-if="field.fieldType === 'agent-owner-field'">
       <div ng-if="field.config.entityField === 'pessoaDeficiente'">
            <span ng-if="checkField(entity[field.fieldName])" ng-bind-html="checkField(entity[field.fieldName])"></span>
            <span ng-if="!checkField(entity[field.fieldName])"><em><?php \MapasCulturais\i::_e("Campo não informado."); ?></em></span>
       </div>

       <div ng-if="field.config.entityField !== 'pessoaDeficiente'">
            <span ng-if="entity[field.fieldName] && field.fieldType !== 'textarea'" ng-bind-html="printField(field, entity[field.fieldName])"></span>
            <p ng-if="entity[field.fieldName] && field.fieldType === 'textarea'" ng-bind-html="printField(field, entity[field.fieldName])" style="white-space: pre-line"></p>
            <span ng-if="!entity[field.fieldName]"><em><?php \MapasCulturais\i::_e("Campo não informado."); ?></em></span>
       </div>
    </div>
</div>
<div ng-if="field.fieldType === 'section'">
    <h4>{{field.title}}</h4>
</div>
<div ng-if="field.fieldType === 'persons'">
    <label>{{field.required ? '*' : ''}} {{field.title}}: </label>
    <div ng-repeat="(key, item) in entity[field.fieldName]" ng-if="item && key !== 'location' && key !== 'publicLocation'">
        <div style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
            <strong>{{key + 1}}ª Pessoa:</strong><br>
            <span ng-if="item.name"><b>Nome: </b>{{item.name}}<br></span>
            <span ng-if="item.fullName"><b>Nome completo: </b>{{item.fullName}}<br></span>
            <span ng-if="item.socialName"><b>Nome social: </b>{{item.socialName}}<br></span>
            <!-- <span ng-if="item.cpf"><b>CPF: </b>{{item.cpf}}<br></span>
            <span ng-if="item.income"><b>Renda: </b>{{item.income}}<br></span>
            <span ng-if="item.education"><b>Escolaridade: </b>{{item.education}}<br></span>
            <span ng-if="item.telephone"><b>Telefone: </b>{{item.telephone}}<br></span>
            <span ng-if="item.email"><b>Email: </b>{{item.email}}<br></span>
            <span ng-if="item.race"><b>Raça/Cor: </b>{{item.race}}<br></span>
            <span ng-if="item.gender"><b>Gênero: </b>{{item.gender}}<br></span>
            <span ng-if="item.sexualOrientation"><b>Orientação sexual: </b>{{item.sexualOrientation}}<br></span>
            <span ng-if="item.comunty"><b>Comunidade tradicional: </b>{{item.comunty}}<br></span>
            <span ng-if="item.area && item.area.length"><b>Áreas de atuação: </b>{{item.area.join(', ')}}<br></span>
            <span ng-if="item.funcao && item.funcao.length"><b>Funções: </b>{{item.funcao.join(', ')}}<br></span>
            <span ng-if="item.deficiencies">
                <b>Deficiências: </b>
                <span ng-repeat="(deficiency, value) in item.deficiencies" ng-if="value">
                    {{deficiency}}{{!$last ? ', ' : ''}}
                </span>
                <br>
            </span> -->
        </div>
    </div>
    <div ng-if="!entity[field.fieldName] || entity[field.fieldName].length === 0">
        <em><?php \MapasCulturais\i::_e("Campo não informado."); ?></em>
</div>
<?php //@TODO pegar endereço do campo endereço (verificar porque não esta salvando corretamente, arquicos location.js e _location.php)
?>
<div ng-if="field.config.entityField === '@location'">
    <label>{{field.required ? '*' : ''}} {{field.title}}: </label>
    <div ng-repeat="(key, item) in entity[field.fieldName]"
        ng-if="key !== 'location' && key !== 'publicLocation' && !(item.En_CEP === '' && item.En_Estado === '' && item.En_Nome_Logradouro === '' && item.En_Num === '' && item.En_Bairro === '' && item.En_Complemento === '' && item.En_Pais === '' && item.En_Municipio === '')">
        <span>{{ key.split('_').pop() }}: {{ item }}</span>
    </div>
    <div ng-if="entity[field.fieldName].hasOwnProperty('publicLocation')">
        <span>
            <?php \MapasCulturais\i::_e("Este endereço pode ficar público na plataforma?:"); ?>
                {{ entity[field.fieldName].publicLocation === true ? 'Sim' : 'Não' }}
        </span>
    </div>
</div>

<div ng-if="field.config.entityField === '@links' || field.fieldType === 'links' || checkRegistrationFields(field, 'links')">
    <label>{{field.required ? '*' : ''}} {{field.title}}: </label>
    <div ng-repeat="(key, item) in entity[field.fieldName]" ng-if="item && key !== 'location' && key !== 'publicLocation' ">
        <b>{{item.title}}:</b> <a target="_blank" href="{{item.value}}">{{item.value}}</a>
    </div>
</div>

<div ng-if="field.fieldType === 'url'">
    <label>{{field.required ? '*' : ''}} {{field.title}}: </label>
    <div ng-if="entity[field.fieldName]">
        <a ng-click="openLink($event, entity[field.fieldName])">{{entity[field.fieldName]}}</a>
    </div>
    <div ng-if="!entity[field.fieldName]">
        <em><?php \MapasCulturais\i::_e("Campo não informado."); ?></em>
    </div>
</div>

<div ng-if="field.fieldType === 'file'">
    <label>{{::field.required ? '*' : ''}} {{::field.title}}: </label>
    <a ng-if="field.file" class="attachment-title" ng-click="openLink($event, field.file.url)" rel='noopener noreferrer'>{{::field.file.name}}</a>
    <span ng-if="!field.file"><em><?php \MapasCulturais\i::_e("Arquivo não enviado."); ?></em></span>
</div>
<?php $this->applyTemplateHook('registration-field-item', 'end') ?>
