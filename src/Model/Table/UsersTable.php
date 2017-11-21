<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Conferences
 * @property \Cake\ORM\Association\HasMany $SessionFeedbacks
 * @property \Cake\ORM\Association\HasMany $Speakers
 * @property \Cake\ORM\Association\HasMany $Votes
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Conferences', [
            'foreignKey' => 'conference_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('SessionFeedbacks', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Speakers', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Votes', [
            'foreignKey' => 'user_id'
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
            ->allowEmpty('originid');

        $validator
            ->requirePresence('mail', 'create')
            ->notEmpty('mail');

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->requirePresence('hash', 'create')
            ->notEmpty('hash');

        $validator
            ->integer('vote_page_view')
            ->requirePresence('vote_page_view', 'create')
            ->notEmpty('vote_page_view');

        $validator
            ->allowEmpty('avatar_icon_filename');

        $validator
            ->allowEmpty('qr_filename');

        $validator
            ->allowEmpty('name');

        $validator
            ->allowEmpty('ticket_type');

        $validator
            ->requirePresence('ticket_no', 'create')
            ->notEmpty('ticket_no');

        $validator
            ->allowEmpty('sns_accounts');

        $validator
            ->allowEmpty('ticket_json');

        $validator
            ->boolean('feedback_email_sent')
            ->allowEmpty('feedback_email_sent');

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
