<?php

namespace ThemeHouse\InstallAndUpgrade\XF\Entity;

class AddOnInstallBatch extends XFCP_AddOnInstallBatch
{
    protected $thLastAddedAddOnId;

    public function thLastAddedAddOnId()
    {
        return $this->thLastAddedAddOnId;
    }

    public function addAddOn($addOnId, $title, $newVersionId, $newVersionString, $tempFile)
    {
        $this->thLastAddedAddOnId = $addOnId;

        parent::addAddOn($addOnId, $title, $newVersionId, $newVersionString,
            $tempFile);
    }
}
