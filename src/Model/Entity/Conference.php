<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Conference Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $vote_url_base
 * @property \Cake\I18n\FrozenTime $vote_close_at
 * @property string $class_name
 * @property string $feedback_mail_body
 * @property string $feedback_mail_from
 * @property string $feedback_mail_from_name
 * @property string $feedback_mail_subject
 * @property string $feedback_report_mail_body
 * @property string $feedback_report_mail_from
 * @property string $feedback_report_mail_from_name
 * @property string $feedback_report_mail_subject
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\SessionFeedbackQuestion[] $session_feedback_questions
 * @property \App\Model\Entity\Session[] $sessions
 * @property \App\Model\Entity\Track[] $tracks
 * @property \App\Model\Entity\User[] $users
 * @property \App\Model\Entity\VoteGroup[] $vote_groups
 */
class Conference extends Entity
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
