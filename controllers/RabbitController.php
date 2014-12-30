<?php
class RabbitController extends Controller
{
public function __construct()
{
	parent::__construct();
	// loadHelper('url'); 
	// redirect('pages/view/our-mission');
	
}

public function indexAction()
{
	$data['matinglist']=getModel('rabbitnew')->rabbitMattinglist();
	$this->view->render('rabbit/rabbitcomparenew.phtml',$data);
}

public function twoRabbitMattingCheckAction()
{
	loadHelper('inputs');
	$post_data		=	getPost();
	if($post_data)
	{
		//$data['result']='true';
		$data['result']=getModel('rabbitnew')->rabbitmate($_POST['rabbit_x'],$_POST['rabbit_y']);
		$data['matinglist']=getModel('rabbitnew')->rabbitMattinglist();
		$this->view->render('rabbit/rabbitcomparenew.phtml',$data);
	}
	else
	{ 
	$data['matinglist']=getModel('rabbitnew')->rabbitMattinglist();
	$this->view->render('rabbit/rabbitcomparenew.phtml',$data);
	}
}

public function addrabbitAction()
{
	$data['family_id']=getModel('rabbitnew')->getfamilyid();
	$data['litter_id']=getModel('rabbitnew')->rabbitelement('l_id','aa_litter',null,null);
	$data['does_id']=getModel('rabbitnew')->rabbitelement('r_id','aa_rabbits','D','type'); //echo'<pre>';var_dump($data['does_id']); echo'</pre>';die();
	$data['buck_id']=getModel('rabbitnew')->rabbitelement('r_id','aa_rabbits','B','type');
	$this->view->render('rabbit/newrabbit.phtml',$data);
}

public function insertrabbitAction()
{
	loadHelper('inputs');
	$post_data		=	getPost();
	loadHelper('url');
	if($post_data)
	{

		$result=getModel('rabbitnew')->insertrabbit($post_data);

		if($result)
		{ 
			$data['succesfull']='Succesfully inserted rabbit';
			$this->view->render('rabbit/newrabbit.phtml',$data);
		}		
	}
	else
	{
		$this->addrabbitAction();
	}
}

}