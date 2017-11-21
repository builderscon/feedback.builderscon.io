<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Conferences Model
 *
 * @property \Cake\ORM\Association\HasMany $SessionFeedbackQuestions
 * @property \Cake\ORM\Association\HasMany $Sessions
 * @property \Cake\ORM\Association\HasMany $Tracks
 * @property \Cake\ORM\Association\HasMany $Users
 * @property \Cake\ORM\Association\HasMany $VoteGroups
 *
 * @method \App\Model\Entity\Conference get($primaryKey, $options = [])
 * @method \App\Model\Entity\Conference newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Conference[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Conference|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Conference patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Conference[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Conference findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ConferencesTable extends Table
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

        $this->setTable('conferences');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('SessionFeedbackQuestions', [
            'foreignKey' => 'conference_id'
        ]);
        $this->hasMany('Sessions', [
            'foreignKey' => 'conference_id'
        ]);
        $this->hasMany('Tracks', [
            'foreignKey' => 'conference_id'
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'conference_id'
        ]);
        $this->hasMany('VoteGroups', [
            'foreignKey' => 'conference_id'
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
            ->requirePresence('slug', 'create')
            ->notEmpty('slug');

        $validator
            ->requirePresence('vote_url_base', 'create')
            ->notEmpty('vote_url_base');

        $validator
            ->dateTime('vote_close_at')
            ->allowEmpty('vote_close_at');

        $validator
            ->requirePresence('class_name', 'create')
            ->notEmpty('class_name');

        $validator
            ->allowEmpty('feedback_mail_body');

        $validator
            ->allowEmpty('feedback_mail_from');

        $validator
            ->allowEmpty('feedback_mail_from_name');

        $validator
            ->allowEmpty('feedback_mail_subject');

        $validator
            ->allowEmpty('feedback_report_mail_body');

        $validator
            ->allowEmpty('feedback_report_mail_from');

        $validator
            ->allowEmpty('feedback_report_mail_from_name');

        $validator
            ->allowEmpty('feedback_report_mail_subject');

        return $validator;
    }
}
