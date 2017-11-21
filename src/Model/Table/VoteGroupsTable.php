<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VoteGroups Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Conferences
 * @property \Cake\ORM\Association\HasMany $Sessions
 *
 * @method \App\Model\Entity\VoteGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\VoteGroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VoteGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VoteGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VoteGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VoteGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VoteGroup findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class VoteGroupsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('vote_groups');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Conferences', [
            'foreignKey' => 'conference_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Sessions', [
            'foreignKey' => 'vote_group_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->allowEmpty('slug');

        $validator
            ->integer('voting_cards')
            ->requirePresence('voting_cards', 'create')
            ->notEmpty('voting_cards');

        $validator
            ->dateTime('voting_close_at')
            ->requirePresence('voting_close_at', 'create')
            ->notEmpty('voting_close_at');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['conference_id'], 'Conferences'));

        return $rules;
    }
}
