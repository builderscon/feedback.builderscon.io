<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SessionFeedbackAnswer Entity
 *
 * @property int $id
 * @property int $session_feedback_id
 * @property int $session_feedback_question_id
 * @property string $answer
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\SessionFeedback $session_feedback
 * @property \App\Model\Entity\SessionFeedbackQuestion $session_feedback_question
 */
class SessionFeedbackAnswer extends Entity
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
