<?php
/**
 * Project: thinkphp-inaction
 * User: xialei
 * Date: 2016/9/19 0019
 * Time: 15:56
 */

namespace Common\Model;


use Think\Exception;
use Think\Model;

/**
 * 版块model
 * Class BoardModel
 * @package Common\Model
 */
class BoardModel extends Model
{

    public $_validate = array(
        array('name', 'require', '版块名称不能为空'),
        array('icon', 'require', '版块图标不能为空'),
        array('rules', 'require', '板块规则不能为空')
    );

    public $_auto = array(
        array('enabled', 'setEnabled', self::MODEL_BOTH, 'callback'),
    );

    public function setEnabled()
    {
        if (empty($_POST['enabled'])) {
            return 0;
        } else {
            return 1;
        }
    }

    /**
     * 所有版块
     * @param null $enabled
     * @return mixed
     */
    public function all($enabled = null)
    {
        $condition = array();
        if (!is_null($enabled)) {
            $condition['enabled'] = $enabled;
        }
        return $this->where($condition)->select();
    }

    /**
     * 编辑|添加版块
     * @param array $data
     * @param null $id
     * @throws Exception
     */
    public function post(array $data, $id = null)
    {
        if (!$this->create($data)) {
            throw new  Exception($this->getError());
        }
        //上传处理
        if ($id === null) {
            if (!$this->add()) {
                throw new Exception('添加失败');
            }
        } else {
            if ($this->where(array('boardId' => $id))->save() === false) {
                throw new Exception('编辑失败');
            }
        }
    }
}