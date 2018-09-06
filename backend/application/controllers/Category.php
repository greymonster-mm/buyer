<?php
use Yaf\Controller\BaseController;
use Yaf\Model\Repository\BlogArticleRepository;

/**
 * 分类相关接口
 *
 * @name CategoryController
 * @author menmei
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class CategoryController extends BaseController
{

    private $goodRepo;

    protected function init()
    {
        parent::init();
        $this->categoryRepo = $this->em->getRepository('Yaf\Model\Entities\Category');
    }

    /**
     * 获得分类列表的接口
     * @return Json
     */
    public function getCategoryTreeAction()
    {
    	$pid =  $this->request('pid', 0);
    	$expand =  $this->request('expand', true);
    	$render = $this->request('render', false);
        $tree = $this->categoryRepo->getCategoryTree($pid, $render, $expand);
        return $this->jsonReturn($tree);
    }

    /**
     * 删除分类列表的接口
     * @return Json
     */
    public function deleteCategoryTreeAction()
    {
    	$cid =  $this->request('cid');
    	if (!$cid)
    	{
    		$this->jsonReturn('参数非法!', Common::CODE_ERROR);

    	}
    	$ret = $this->categoryRepo->deleteCategoryTree($cid);
    	return $this->jsonReturn($ret['data'], $ret['code']);
    }

    /**
     * 添加分类列表的接口
     * @return Json
     */
    public function addCategoryTreeAction()
    {
    	$pid =  $this->request('pid');
    	$name = $this->request('name', '');
    	if (!$pid || !$name)
    	{
    		$this->jsonReturn('参数非法!', Common::CODE_ERROR);

    	}
    	$ret = $this->categoryRepo->addCategoryTree($pid, $name);
    	return $this->jsonReturn($ret['data'], $ret['code']);
    }
    /**
     * 获得分类下属分类列表
     * @return Json
     */
    public function getCategoryChildsAction()
    {
    	$pid =  $this->postdata['pid'] ?  $this->postdata['pid'] : 0;
    	$childs = $this->categoryRepo->getCategoryChilds($pid);
    	return $this->jsonReturn($childs);
    }

    /**
     * 获取分类父分类列表
     * @return Json
     */
	public function getCategoryParentsAction()
	{
		$cid =  $this->postdata['cid'] ?  $this->postdata['cid'] : 0;
		$parents = $this->categoryRepo->getCategoryParents($cid);
		$parents = array_reverse($parents);
		return $this->jsonReturn($parents);
	}

}
