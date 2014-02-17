<?php
namespace UserTest;

use RbacUserDoctrineOrm\Entity\User;
use RbacUserDoctrineOrm\Entity\Role;
use Doctrine\ORM\PersistentCollection;
use RbacUserDoctrineOrmTest\Bootstrap;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @covers \Rbac\Role\Role
 * @group Coverage
 */
class UserTest extends \PHPUnit_Framework_TestCase
{	
	protected $_roleAdministrator = null;
	protected $_roleUser = null;
	protected $_user = null;
	
	/**
     * @covers RbacUserDoctrineOrm\Entity\User::setRoles
     */
    public function testCanSetRolesUser()
    {    	
    	$entityManager = Bootstrap::getEntityManager();
    	$roleAdmin = new Role('admin');
    	$roleMember = new Role('member');
    	
    	$entityManager->persist($roleAdmin);
    	$entityManager->persist($roleMember);
    	
    	$user = new User();
    	$user->setDisplayName('username');
    	$user->setEmail('username@host.com');
    	$user->setPassword('-');
    	$user->setState(1);
    	$entityManager->persist($user);
    	
    	$this->assertCount(0, $user->getRoles());
    	
    	$collection = new ArrayCollection();
    	$collection->add($roleAdmin);
    	$collection->add($roleMember);
    	$user->setRoles($collection);
    	$entityManager->flush();
        $this->assertCount(2, $user->getRoles());
        
        $collection = new ArrayCollection();
        $collection->add($roleAdmin);
        $collection->add($roleAdmin);
        $user->setRoles($collection);
        $entityManager->flush();
        $this->assertCount(1, $user->getRoles());
    }
    
    /**
     * @covers RbacUserDoctrineOrm\Entity\User::addRole
     */
    public function testCanAddRoleUser()
    {
    	$entityManager = Bootstrap::getEntityManager();
    	
    	$user = $entityManager->getRepository('RbacUserDoctrineOrm\Entity\User')->findOneBy(array('email' => 'username@host.com'));
    	$this->assertNotNull($user);
    	
    	$user->setRoles(new ArrayCollection());
    	$entityManager->flush();
    	$this->assertCount(0, $user->getRoles());
    	
    	$roleAdmin = $entityManager->getRepository('RbacUserDoctrineOrm\Entity\Role')->findOneBy(array('name' => 'admin'));
    	$roleMember = $entityManager->getRepository('RbacUserDoctrineOrm\Entity\Role')->findOneBy(array('name' => 'member'));
    	$user->addRole($roleAdmin);
    	$user->addRole($roleMember);
    	$entityManager->flush();
    	$this->assertCount(2, $user->getRoles());
    	
    	$user->setRoles(new ArrayCollection());
    	$entityManager->flush();
    	$user->addRole($roleAdmin);
    	$user->addRole($roleAdmin);
    	$entityManager->flush();
    	$this->assertCount(1, $user->getRoles());
    }
}
