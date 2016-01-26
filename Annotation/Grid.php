<?php

namespace Symfonian\Indonesia\AdminBundle\Annotation;

/*
 * Author: Muhammad Surya Ihsanuddin<surya.kejawen@gmail.com>
 * Url: https://github.com/ihsanudin.
 */
use Symfonian\Indonesia\AdminBundle\Configuration\ConfigurationInterface;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
class Grid implements ConfigurationInterface
{
    protected $gridFields = array();

    protected $gridFilters = array();

    protected $normalizeFilter = false;

    protected $formatNumber = true;

    public function __construct(array $data = array())
    {
        if (isset($data['value'])) {
            $this->gridFields = $data['value'];
        }

        if (isset($data['fields'])) {
            if (!is_array($data['fields'])) {
                $data['fields'] = (array) $data['fields'];
            }

            $this->gridFields = $data['fields'];
        }

        if (isset($data['filter'])) {
            if (!is_array($data['filter'])) {
                $data['filter'] = (array) $data['filter'];
            }

            $this->gridFilters = $data['filter'];
        }

        if (isset($data['normalizeFilter'])) {
            $this->normalizeFilter = (bool) $data['normalizeFilter'];
        }

        if (isset($data['formatNumber'])) {
            $this->formatNumber = (bool) $data['formatNumber'];
        }

        unset($data);
    }

    public function getGridFields()
    {
        return $this->gridFields;
    }

    public function setGridFields(array $gridFields)
    {
        $this->gridFields = $gridFields;
    }

    public function getGridFilter()
    {
        return $this->gridFilters;
    }

    public function setGridFilters(array $filters)
    {
        $this->gridFilters = $filters;
    }

    public function isNormalizeFilter()
    {
        return $this->normalizeFilter;
    }

    public function isFormatNumber()
    {
        return $this->formatNumber;
    }

    public function getName()
    {
        return 'grid';
    }
}