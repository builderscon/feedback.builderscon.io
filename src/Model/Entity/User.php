<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $originid
 * @property string $mail
 * @property string $password
 * @property int $conference_id
 * @property string $hash
 * @property int $vote_page_view
 * @property string $avatar_icon_filename
 * @property string $qr_filename
 * @property string $name
 * @property string $ticket_type
 * @property string $ticket_no
 * @property string $sns_accounts
 * @property string $ticket_json
 * @property bool $feedback_email_sent
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Conference $conference
 * @property \App\Model\Entity\SessionFeedback[] $session_feedbacks
 * @property \App\Model\Entity\Speaker[] $speakers
 * @property \App\Model\Entity\Vote[] $votes
 */
class User extends Entity
{
    use \App\Classes\Model\Entity\ExtUserTrait;

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

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
