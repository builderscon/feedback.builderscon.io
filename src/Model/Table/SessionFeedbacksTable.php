<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SessionFeedbacks Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Sessions
 * @property \Cake\ORM\Association\HasMany $SessionFeedbackAnswers
 *
 * @method \App\Model\Entity\SessionFeedback get($primaryKey, $options = [])
 * @method \App\Model\Entity\SessionFeedback newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SessionFeedback[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SessionFeedback|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SessionFeedback patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SessionFeedback[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SessionFeedback findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SessionFeedbacksTable extends Table
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

        $this->setTable('session_feedbacks');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Sessions', [
            'foreignKey' => 'session_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('SessionFeedbackAnswers', [
            'foreignKey' => 'session_feedback_id'
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
            ->boolean('is_reviewed')
            ->requirePresence('is_reviewed', 'create')
            ->notEmpty('is_reviewed');

        $validator
            ->allowEmpty('review_memo');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['session_id'], 'Sessions'));

        return $rules;
    }
}
