<?php
/**
 * Created by PhpStorm.
 * User: belka759
 * Date: 07/05/17
 * Time: 03:47 م
 */

namespace FOSuBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM ;


/**
 * Class UserAdmin
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name= "user_admin")
 *
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->roles = array('ROLE_MACHIN');
    }



}
