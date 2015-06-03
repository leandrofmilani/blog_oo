<?php

namespace Admin\Service;

use Core\Service\Service;
use Zend\Authentication\AuthenticationService;
use Zend\Autentication\Adapter\DbTable as AuthAdapter;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

/**
 * Servico para autenticacao de um simples usuario
 *
 * @category Admin
 * @package Controller
 * @author  Cezar Junior de Souza <cezar08@unochapeco.edu.br>
 */
class Auth extends Service
{

	/**
	* Faz a autenticacao
	* @param array $params
	* @return array
	*/

	public function authenticate($params)
	{
		if (!isset($params['email']) || !isset($params['senha'])) {
			throw new \Exception("Parametros invalidos");
		}
	$senha = md5($params['senha']);

	$authService = $this->getServiceManager()->get('Zend\Authentication\AuthenticationService');

	$AuthAdapter = $authService->getAdapter();
	$AuthAdapter->setIdentityValue($params['email'])->setCredentialValue($senha);
	$result = $authService->authenticate();

	if (!$result->isValid()) {
		throw new \Exception("Login ou senha invalidos");
	}

	$session = $this->getServiceManager()->get('Session');
	$identity = $result->getIdentity();
	$session->offsetSet('user', $identity);
	$session->offsetSet('role', $identity->getRole());
	$session->offsetSet('id', $identity->getId());


	return true;

	}

	/**
	* Faz logout
	* 
	* @return void
	*/

	public function logout()
	{
		$Auth = new AuthenticationService();
		$session = $this->getServiceManager()->get('Session');
		$session->offsetUnset('user');
		$session->offsetUnset('role');
		$Auth->clearIdentity();

		return true;
	}

	/**
	* Faz a autorizacao do usuario para acessar o recurso
	* @param string $moduleName Nome do modulo sendo acesso
	* @param string $controllerName Nome do controller
	* @param string $actionName nome da acao
	* @return boolean
	*/

	public function authorize($moduleName, $controllerName, $actionName)
	{
		$auth = new AuthenticationService();
		$role = 'VISITANTE';
		if ($auth->hasIdentity()) {
			$session = $this->getServiceManager()->get('Session');
			if (!$session->offsetGet('role'))
				$role = 'VISITANTE';
			else
				$role = $session->offsetGet('role');
		}
		$resource = $controllerName . '.' . $actionName;
		$acl = $this->getServiceManager()->get('Core\Acl\Builder')->build();
		if ($acl->isAllowed($role, $resource)) {
			return true;
		}

		return false;
	}

}