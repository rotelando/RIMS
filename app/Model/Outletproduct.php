<?php

class Outletproduct extends AppModel {

    var $name = 'Outletproduct';
    var $displayField = 'outletproductname';

    var $belongsTo = array(
        'Outlet' => array(
            'className' => 'Outlet',
            'foreignKey' => 'outlet_id',
        ),
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'product_id',
        ),
        'Brand' => array(
            'className' => 'Brand',
            'foreignKey' => 'brand_id',
        )
    );

    public function productsForOutlet($id) {

        $options['fields'] = array(
            'Outletproduct.id',
            'Brand.id',
            'Brand.brandname',
            'Product.id',
            'Product.productname',
            'Outletproduct.created_at'
        );
        $options['order'] = array('Outletproduct.id DESC');
        $options['conditions'] = array('Outletproduct.outlet_id' => $id);
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'INNER',
                'conditions' => array(
                    'Outlet.id = Outletproduct.outlet_id'
                )
            ),
            array(
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'INNER',
                'conditions' => array(
                    'Brand.id = Outletproduct.brand_id'
                )
            ),
            array(
                'table' => 'products',
                'alias' => 'Product',
                'type' => 'INNER',
                'conditions' => array(
                    'Product.id = Outletproduct.product_id'
                )
            )
        );

        $products = $this->find('all', $options);
        return $products;
    }

    public function outletProductDistribution() {

        $options['fields'] = array(
            'Brand.id',
            'Brand.brandname',
            'Productcategory.id',
            'Productcategory.productcategoryname',
            'COUNT(Outletproduct.id) as count'
        );
        $options['order'] = array('Outletproduct.id DESC');
        $options['recursive'] = -1;
        $options['group'] = array('Outletproduct.product_id HAVING count > 0');
        $options['joins'] = array(
            array(
                'table' => 'brands',
                'alias' => 'Brand',
                'type' => 'INNER',
                'conditions' => array(
                    'Brand.id = Outletproduct.brand_id'
                )
            ),
            array(
                'table' => 'productcategories',
                'alias' => 'Productcategory',
                'type' => 'INNER',
                'conditions' => array(
                    'Productcategory.id = Outletproduct.product_id'
                )
            )
        );

        $outletproducts = $this->find('all', $options);
        return $outletproducts;
    }

    public function OutletProductByLocation() {

        //merchandize count by locations
        $options['fields'] = array(
            'State.internalid,
            COUNT(Outletproduct.product_id) as productcount');
        //get for current brand
        //$options['conditions'] = array('brand_id' => '2');
        $options['group'] = array('State.internalid HAVING productcount > 0');
        $options['recursive'] = -1;
        $options['joins'] = array(
            array(
                'table' => 'outlets',
                'alias' => 'Outlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'Outlet.id = Outletproduct.outlet_id'
                )
            ),array(
                'table' => 'locations',
                'alias' => 'Location',
                'type' => 'LEFT',
                'conditions' => array(
                    'Location.id = Outlet.location_id'
                )
            ),
            array(
                'table' => 'lgas',
                'alias' => 'Lga',
                'type' => 'LEFT',
                'conditions' => array(
                    'Lga.id = Location.lga_id'
                )
            ),
            array(
                'table' => 'territories',
                'alias' => 'Territory',
                'type' => 'LEFT',
                'conditions' => array(
                    'Territory.id = Lga.territory_id'
                )
            ),
            array(
                'table' => 'states',
                'alias' => 'State',
                'type' => 'LEFT',
                'conditions' => array(
                    'State.id = Territory.state_id'
                )
            ),
            array(
                'table' => 'productcategories',
                'alias' => 'Productcategory',
                'type' => 'LEFT',
                'conditions' => array(
                    'Productcategory.id = Outletproduct.product_id'
                )
            )
        );
        $productbylocation = $this->find('all', $options);

        return $productbylocation;
        //End outlet count by locations
    }
}