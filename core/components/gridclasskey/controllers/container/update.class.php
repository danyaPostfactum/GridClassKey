<?php

/**
 * Grid Class Key
 *
 * Copyright 2013 by goldsky <goldsky@virtudraft.com>
 *
 * This file is part of Grid Class Key, a custom class key for MODX
 * Revolution's Manager to hide child resources inside container's grid.
 *
 * Grid Class Key is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation version 3,
 *
 * Grid Class Key is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Grid Class Key; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package gridclasskey
 * @subpackage controller
 */
/**
 * @var modX $modx
 */
require_once $modx->getOption('manager_path', null, MODX_MANAGER_PATH) . 'controllers/default/resource/update.class.php';

/**
 * @package gridclasskey
 */
class GridContainerUpdateManagerController extends ResourceUpdateManagerController {

    public function loadCustomCssJs() {
        $managerUrl = $this->context->getOption('manager_url', MODX_MANAGER_URL, $this->modx->_userConfig);
        $gridclasskeyAssetsUrl = $this->modx->getOption('gridclasskey.assets_url'
                , null
                , $this->modx->getOption('assets_url', null, MODX_ASSETS_URL) . 'components/gridclasskey/');
        $connectorUrl = $gridclasskeyAssetsUrl . 'connector.php';
        $gridclasskeyJsUrl = $gridclasskeyAssetsUrl . 'js/';

        $this->addJavascript($managerUrl . 'assets/modext/util/datetime.js');
        $this->addJavascript($managerUrl . 'assets/modext/widgets/element/modx.panel.tv.renders.js');
        $this->addJavascript($managerUrl . 'assets/modext/widgets/resource/modx.grid.resource.security.js');
        $this->addJavascript($managerUrl . 'assets/modext/widgets/resource/modx.panel.resource.tv.js');
        $this->addJavascript($managerUrl . 'assets/modext/widgets/resource/modx.panel.resource.js');
        $this->addJavascript($managerUrl . 'assets/modext/sections/resource/update.js');
        $this->addJavascript($gridclasskeyJsUrl . 'gridclasskey.js');
        $this->addLastJavascript($gridclasskeyJsUrl . 'container/grid.js');
        $this->addLastJavascript($gridclasskeyJsUrl . 'container/common.js');
        $this->addLastJavascript($gridclasskeyJsUrl . 'container/update.js');
        $this->addHtml('
        <script type="text/javascript">
        // <![CDATA[
        GridClassKey.assets_url = "' . $gridclasskeyAssetsUrl . '";
        GridClassKey.connector_url = "' . $connectorUrl . '";
        MODx.config.publish_document = "' . $this->canPublish . '";
        MODx.onDocFormRender = "' . $this->onDocFormRender . '";
        MODx.ctx = "' . $this->resource->get('context_key') . '";
        Ext.onReady(function() {
            MODx.load({
                xtype: "gridclasskey-page-container-update"
                ,resource: "' . $this->resource->get('id') . '"
                ,record: ' . $this->modx->toJSON($this->resourceArray) . '
                ,publish_document: "' . $this->canPublish . '"
                ,preview_url: "' . $this->previewUrl . '"
                ,locked: ' . ($this->locked ? 1 : 0) . '
                ,lockedText: "' . $this->lockedText . '"
                ,canSave: ' . ($this->canSave ? 1 : 0) . '
                ,canEdit: ' . ($this->canEdit ? 1 : 0) . '
                ,canCreate: ' . ($this->canCreate ? 1 : 0) . '
                ,canDuplicate: ' . ($this->canDuplicate ? 1 : 0) . '
                ,canDelete: ' . ($this->canDelete ? 1 : 0) . '
                ,show_tvs: ' . (!empty($this->tvCounts) ? 1 : 0) . '
                ,mode: "update"
            });
        });
        // ]]>
        </script>');
    }

    public function getLanguageTopics() {
        return array('resource', 'gridclasskey:default');
    }

    public function getPageTitle() {
        return $this->modx->lexicon('gridclasskey.container_update');
    }

}
