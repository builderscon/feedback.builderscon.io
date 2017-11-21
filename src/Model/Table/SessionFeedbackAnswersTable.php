<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SessionFeedbackAnswers Model
 *
 * @property \Cake\ORM\Association\BelongsTo $SessionFeedbacks
 * @property \Cake\ORM\Association\BelongsTo $SessionFeedbackQuestions
 *
 * @method \App\Model\Entity\SessionFeedbackAnswer get($primaryKey, $options = [])
 * @method \App\Model\Entity\SessionFeedbackAnswer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SessionFeedbackAnswer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SessionFeedbackAnswer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SessionFeedbackAnswer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SessionFeedbackAnswer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SessionFeedbackAnswer findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SessionFeedbackAnswersTable extends Table
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

        $this->setTable('session_feedback_answers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('SessionFeedbacks', [
            'foreignKey' => 'session_feedback_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SessionFeedbackQuestions', [
            'foreignKey' => 'session_feedback_question_id',
            'joinType' => 'INNER'
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
            ->allowEmpty('answer');

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
        $rules->add($rules->existsIn(['session_feedback_id'], 'SessionFeedbacks'));
        $rules->add($rules->existsIn(['session_feedback_question_id'], 'SessionFeedbackQuestions'));

        return $rules;
    }
}
