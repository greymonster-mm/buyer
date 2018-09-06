<?php
use Yaf\Controller\BaseController;
use Yaf\Model\Repository\GoodRepository;

/**
 * Good相关接口
 *
 * @name ArticleController
 * @author menmei
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class GoodController extends BaseController
{

    protected function init()
    {
        parent::init();
        $this->categoryRepo = $this->em->getRepository('Yaf\Model\Entities\Category');
        $this->goodRepo = $this->em->getRepository('Yaf\Model\Entities\Goods');
    }

    public function checkProductNameAction()
    {
        $name = $this->request('name');
        $id = $this->request('id', 0);
        $ret = $this->goodRepo->checkProductName($name, $id);
        return $this->jsonReturn(['exist' => $ret]);
    }
    /**
     * 获得文章标题和简介的接口
     * @param ctime 创建时间 默认显示所有
     * @param category 文章的分类 默认显示所有
     * @param limit 每页显示多少条文章简介 默认10条
     * @param page 显示第几页文章简介 默认第1页
     * @return Json
     */
    public function getGoodsIntroAction()
    {
        $where = [];

        if ($this->request('category', false))
        {
            $where['category'] = $this->request('category');
        }
        if ($this->request('low', false))
        {
            $where['low'] = $this->request('low');
        }
        if ($this->request('product_name', false))
        {
            $where['product_name'] = $this->request('product_name');
        }
        if ($this->request('high', false))
        {
            $where['high'] = $this->request('high');
        }
        if ($this->request('creator', false))
        {
            $where['creator'] = $this->request('creator');
        }
        if ($this->request('send_times', false))
        {
            $where['send_times'] = $this->request('send_times');
        }
        if ($this->request('brand', false))
        {
            $where['brand'] = $this->request('brand');
        }

        $sorts = ['id' => 'desc'];
        $limit = $this->postdata['limit'] ? $this->postdata['limit'] : 5;
        $page = $this->postdata['page'] ? $this->postdata['page'] : 1;
        $page = $page - 1;
        $data = $this->goodRepo->getGoodsIntroList($where, $page, $limit, $sorts);
        foreach ($data['data'] as &$d)
        {
            $d['ctime'] = date('Y-m-d H:i:s', $d['ctime']);
        }
        return $this->jsonReturn($data);
    }

    /**
     * 获得文章标题和简介的接口(datatables)
     * @param ctime 创建时间 默认显示所有
     * @param category 文章的分类 默认显示所有
     * @param limit 每页显示多少条文章简介 默认10条
     * @param page 显示第几页文章简介 默认第1页
     * @return Json
     */
    public function getGoodsIntroDatatablesAction()
    {
        $columns = [
            'a.id',
            'a.id',
            'a.brand',
            'a.product_name',
            'd.name',
            'a.price',
            'a.suggested_price',
            'a.other_price',
            'a.creator',
            'a.ctime',
            'a.id'
                ];
        //$where['ctime'] = $this->request('ctime');
        //$where['category'] = $this->request('category');
        $limit = $this->request('length', 10);
        $page = $this->request('start', 0);
        $page = ($page)/$limit;
        $order = $this->request('order');
        $search = $this->request('search');
        $where['search'] = $search['value'] ? $search['value'] : false;

        $order = [ $columns[$order[0]['column']] => $order[0]['dir'] ];
        $data = $this->goodRepo->getGoodsIntroList($where, $page, $limit, $order);
        foreach ($data['data'] as &$d)
        {
            $d['ctime'] = date('Y-m-d H:i:s', $d['ctime']);
            $d['utime'] = date('Y-m-d H:i:s', $d['utime']);
        }

        $ret['recordsTotal'] = $data['total'];
        $ret['draw'] = $this->request('draw') + 1;
        $ret['recordsFiltered'] = $data['total'];
        $ret['data'] = $data['data'];
        echo json_encode($ret);
        die;
    }

    /**
     * 获得商品接口
     * @param aid 文章id
     * @return Json
     */
    public function getGoodByIdAction()
    {
    	$id = $this->request('id', '');
    	$article = [];
    	if ($id)
    	{
    		$article = $this->goodRepo->getGoodById($id);
    	}
    	return $this->jsonReturn($article);
    }

    /**
     * 新建商品
     */
    public function addGoodAction()
    {

        $params = [];
        $params['brand'] = $this->request('brand');
        $params['product_name'] = $this->request('product_name');
        $params['description'] = $this->request('description', "");
        $params['if_valid'] = $this->request('if_valid', true);
        $params['other_price'] = $this->request('other_price', 0);
        $params['price'] = $this->request('price', 0);
        $params['suggested_price'] = $this->request('suggested_price', 0);
        $params['ad_copy'] = $this->request('ad_copy', "");
        $params['images'] = $this->request('images', []);
        $params['category'] = $this->request('category', 1);
        $params['creator'] = $this->user;
        $ret = $this->goodRepo->addGood($params);
    	return $this->jsonReturn($ret['message'], $ret['code']);
    }

    /**
     * 上传图片
     */
    public function uploadAction()
    {
        $file = $_FILES['file'];
        if ($file['error'])
        {
            return $this->jsonReturn("上传失败1！", 1);
        }
        $sha1 = sha1_file($file['tmp_name']);
        $file_path = pathinfo($file['name']);
        $prefix = $file_path['extension'];
        $upload_path = getcwd() . "/public/" . $sha1 . '.' . $prefix; //上传文件的存放路径
        //开始移动文件到相应的文件夹
        if(move_uploaded_file($file['tmp_name'], $upload_path))
        {
            return $this->jsonReturn("/public/" . $sha1 . '.' . $prefix, 0);
        }else{
            return $this->jsonReturn("上传失败2！", 1);
        }
    }

    /**
     * 编辑商品
     */
    public function updateGoodAction()
    {
    	$id = $this->request('id', '');
    	$params = [];
        $params['brand'] = $this->request('brand');
        $params['product_name'] = $this->request('product_name');
        $params['description'] = $this->request('description', "");
        $params['if_valid'] = $this->request('if_valid', true);
        $params['other_price'] = $this->request('other_price', 0);
        $params['price'] = $this->request('price', 0);
        $params['suggested_price'] = $this->request('suggested_price', 0);
        $params['ad_copy'] = $this->request('ad_copy', "");
        $params['images'] = $this->request('images', []);
        $params['category'] = $this->request('category', 1);
        $params['creator'] = $this->user;

    	if (!$id)
    	{
    		return $this->jsonReturn('参数非法!', Common::CODE_ERROR);
    	}

    	$ret = $this->goodRepo->updateGood($id, $params);
    	return $this->jsonReturn($ret['message'], $ret['code']);
    }

    /**
     * 删除商品
     * @return Json
     */
    public function deleteGoodAction()
    {
    	$id = $this->request('id', '');
    	if (!$id)
    	{
    		return $this->jsonReturn('参数非法!', Common::CODE_ERROR);
    	}
    	$ret = $this->goodRepo->deleteGood($id);
    	return $this->jsonReturn($ret['message'], $ret['code']);
    }

    /**
     * 增加一次发送次数
     */
    public function addSendTimesAction()
    {
        $gid = $this->request('gid', '');
        $ret = $this->goodRepo->addSendTimes($gid);
        return $this->jsonReturn($ret['message'], $ret['code']);

    }

}
