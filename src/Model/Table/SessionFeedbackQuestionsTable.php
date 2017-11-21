<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SessionFeedbackQuestions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Conferences
 * @property \Cake\ORM\Association\HasMany $SessionFeedbackAnswers
 *
 * @method \App\Model\Entity\SessionFeedbackQuestion get($primaryKey, $options = [])
 * @method \App\Model\Entity\SessionFeedbackQuestion newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SessionFeedbackQuestion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SessionFeedbackQuestion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SessionFeedbackQuestion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SessionFeedbackQuestion[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SessionFeedbackQuestion findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SessionFeedbackQuestionsTable extends Table
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

        $this->setTable('session_feedback_questions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Conferences', [
            'foreignKey' => 'conference_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('SessionFeedbackAnswers', [
            'foreignKey' => 'session_feedback_question_id'
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
            ->integer('question_no')
            ->requirePresence('question_no', 'create')
            ->notEmpty('question_no');

        $validator
            ->allowEmpty('lang');

        $validator
            ->allowEmpty('question');

        $validator
            ->allowEmpty('question_type');

        $validator
            ->allowEmpty('option_json');

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
