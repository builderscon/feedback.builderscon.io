<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SessionFeedback Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $session_id
 * @property bool $is_reviewed
 * @property string $review_memo
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Session $session
 * @property \App\Model\Entity\SessionFeedbackAnswer[] $session_feedback_answers
 */
class SessionFeedback extends Entity
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
