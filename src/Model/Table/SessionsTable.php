<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sessions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Conferences
 * @property \Cake\ORM\Association\BelongsTo $Tracks
 * @property \Cake\ORM\Association\BelongsTo $Speakers
 * @property \Cake\ORM\Association\BelongsTo $VoteGroups
 * @property \Cake\ORM\Association\HasMany $SessionFeedbacks
 * @property \Cake\ORM\Association\HasMany $Votes
 *
 * @method \App\Model\Entity\Session get($primaryKey, $options = [])
 * @method \App\Model\Entity\Session newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Session[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Session|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Session patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Session[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Session findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SessionsTable extends Table
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

        $this->setTable('sessions');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Conferences', [
            'foreignKey' => 'conference_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Tracks', [
            'foreignKey' => 'track_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Speakers', [
            'foreignKey' => 'speaker_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('VoteGroups', [
            'foreignKey' => 'vote_group_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('SessionFeedbacks', [
            'foreignKey' => 'session_id'
        ]);
        $this->hasMany('Votes', [
            'foreignKey' => 'session_id'
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
            ->allowEmpty('source_identifier');

        $validator
            ->dateTime('start_at')
            ->allowEmpty('start_at');

        $validator
            ->integer('duration_min')
            ->allowEmpty('duration_min');

        $validator
            ->integer('number_of_votes')
            ->requirePresence('number_of_votes', 'create')
            ->notEmpty('number_of_votes');

        $validator
            ->requirePresence('hash', 'create')
            ->notEmpty('hash');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->allowEmpty('description');

        $validator
            ->boolean('is_vote_target')
            ->requirePresence('is_vote_target', 'create')
            ->notEmpty('is_vote_target');

        $validator
            ->boolean('is_feedback_target')
            ->requirePresence('is_feedback_target', 'create')
            ->notEmpty('is_feedback_target');

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
        $rules->add($rules->existsIn(['track_id'], 'Tracks'));
        $rules->add($rules->existsIn(['speaker_id'], 'Speakers'));
        $rules->add($rules->existsIn(['vote_group_id'], 'VoteGroups'));

        return $rules;
    }
}
