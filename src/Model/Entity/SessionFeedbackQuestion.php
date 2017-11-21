<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SessionFeedbackQuestion Entity
 *
 * @property int $id
 * @property int $conference_id
 * @property int $question_no
 * @property string $lang
 * @property string $question
 * @property string $question_type
 * @property string $option_json
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Conference $conference
 * @property \App\Model\Entity\SessionFeedbackAnswer[] $session_feedback_answers
 */
class SessionFeedbackQuestion extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
