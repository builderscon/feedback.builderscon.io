<%
/**
* CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
* Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
*
* Licensed under The MIT License
* For full copyright and license information, please see the LICENSE.txt
* Redistributions of files must retain the above copyright notice.
*
* @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
* @link          http://cakephp.org CakePHP(tm) Project
* @since         0.1.0
* @license       http://www.opensource.org/licenses/mit-license.php MIT License
*/
%>
<?php
/**
 * @var \<%= $namespace %>\View\AppView $this
 */
?>
<%
use Cake\Utility\Inflector;

$fields = collection($fields)
->filter(function($field) use ($schema) {
return !in_array($schema->columnType($field), ['binary', 'text']);
});

if (isset($modelObject) && $modelObject->behaviors()->has('Tree')) {
$fields = $fields->reject(function ($field) {
return $field === 'lft' || $field === 'rght';
});
}

if (!empty($indexColumns)) {
$fields = $fields->take($indexColumns);
}

%>
<div class="row">
    <div class="col s2">
        <ul class="collection with-header">
            <li class="collection-header"><?= __('Actions') ?></li>
            <li class="collection-item"><?= $this->Html->link(__('New <%= $singularHumanName %>'), ['action' => 'add']) ?></li>
            <%
            $done = [];
            foreach ($associations as $type => $data){
            foreach ($data as $alias => $details){
            if (!empty($details['navLink']) && $details['controller'] !== $this->name && !in_array($details['controller'], $done)){
            %>
            <li class="collection-item"><?= $this->Html->link(__('List <%= $this->_pluralHumanName($alias) %>'), ['controller' => '<%= $details['controller'] %>', 'action' => 'index']) ?></li>
            <li class="collection-item"><?= $this->Html->link(__('New <%= $this->_singularHumanName($alias) %>'), ['controller' => '<%= $details['controller'] %>', 'action' => 'add']) ?></li>
            <%
            $done[] = $details['controller'];
            }
            }
            }
            %>
        </ul>
    </div>
    <div class="col s10">
        <div class="<%= $pluralVar %> index large-9 medium-8 columns content">
            <h3><?= __('<%= $pluralHumanName %>') ?></h3>
            <table cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <% foreach ($fields as $field): %>
                    <th scope="col"><?= $this->Paginator->sort('<%= $field %>') ?></th>
                    <% endforeach; %>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($<%= $pluralVar %> as $<%= $singularVar %>): ?>
                <tr>
                    <%        foreach ($fields as $field) {
                    $isKey = false;
                    if (!empty($associations['BelongsTo'])) {
                    foreach ($associations['BelongsTo'] as $alias => $details) {
                    if ($field === $details['foreignKey']) {
                    $isKey = true;
                    %>
                    <td><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></td>
                    <%
                    break;
                    }
                    }
                    }
                    if ($isKey !== true) {
                    if (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
                    %>
                    <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
                    <%
                    } else {
                    %>
                    <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
                    <%
                    }
                    }
                    }

                    $pk = '$' . $singularVar . '->' . $primaryKey[0];
                    %>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', <%= $pk %>]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', <%= $pk %>]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', <%= $pk %>], ['confirm' => __('Are you sure you want to delete # {0}?', <%= $pk %>)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('<i class="material-icons">chevron_left</i>', ['escape' => false]) ?>
                <?= $this->Paginator->numbers(['class' => 'waves-effect']) ?>
                <?= $this->Paginator->next('<i class="material-icons">chevron_right</i>', ['escape' => false]) ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
                <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
        </div>
    </div>
</div>
