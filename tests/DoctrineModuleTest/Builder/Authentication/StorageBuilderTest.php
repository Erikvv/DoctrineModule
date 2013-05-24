<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace DoctrineModuleTest\Builder\Authentication;

use DoctrineModule\Builder\Authentication\StorageBuilder;
use PHPUnit_Framework_TestCase as BaseTestCase;

class StorageBuilderTest extends BaseTestCase
{
    public function testCanInstantiateStorageFromServiceLocator()
    {
        $builder        = new StorageBuilder('testFactory');
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $storage        = $this->getMock('Zend\Authentication\Storage\StorageInterface');
        $objectManager  =  $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $serviceLocator
            ->expects($this->at(0))
            ->method('get')
            ->with('some_storage')
            ->will($this->returnValue($storage));

        $builder->setServiceLocator($serviceLocator);

        $this->assertInstanceOf(
            'DoctrineModule\Authentication\Storage\ObjectRepositoryStorage',
            $builder->build(
                array(
                     'object_manager' => $objectManager,
                     'identity_class' => 'DoctrineModuleTest\Authentication\Adapter\TestAsset\IdentityObject',
                     'storage'        => 'some_storage',
                )
            )
        );
    }
}