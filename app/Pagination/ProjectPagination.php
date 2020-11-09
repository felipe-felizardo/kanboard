<?php

namespace Kanboard\Pagination;

use Kanboard\Core\Base;
use Kanboard\Core\Paginator;
use Kanboard\Model\ProjectModel;

/**
 * Class ProjectPagination
 *
 * @package Kanboard\Pagination
 * @author  Frederic Guillot
 */
class ProjectPagination extends Base
{
    /**
     * Get dashboard pagination
     *
     * @access public
     * @param  integer $user_id
     * @param  string  $method
     * @param  integer $max
     * @return Paginator
     */
    public function getDashboardPaginator($user_id, $method, $max)
    {
        $is_backlog = $method === 'backlogs' ? true : false;
        $query = $this->projectModel->getQueryColumnStats($this->projectPermissionModel->getActiveProjectIds($user_id), $is_backlog);
        $this->hook->reference('pagination:dashboard:project:query', $query);

        return $this->paginator
            ->setUrl('DashboardController', $method, array('pagination' => 'projects', 'user_id' => $user_id))
            ->setMax($max)
            ->setOrder(ProjectModel::TABLE.'.name')
            ->setQuery($query)
            ->calculateOnlyIf($this->request->getStringParam('pagination') === 'projects');
    }
}
