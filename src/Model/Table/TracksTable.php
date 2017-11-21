<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tracks Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Conferences
 * @property \Cake\ORM\Association\HasMany $Sessions
 *
 * @method \App\Model\Entity\Track get($primaryKey, $options = [])
 * @method \App\Model\Entity\Track newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Track[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Track|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Track patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Track[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Track findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TracksTable extends Table
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

        $this->setTable('tracks');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Conferences', [
            'foreignKey' => 'conference_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Sessions', [
            'foreignKey' => 'track_id'
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
            ->integer('display_order')
            ->allowEmpty('display_order');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('slug', 'create')
            ->notEmpty('slug');

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
