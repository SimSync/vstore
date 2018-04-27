<?php

$VSTORE_DASHBOARD_TEMPLATE = array();


$VSTORE_DASHBOARD_TEMPLATE['header'] = '
    <h3>{DASHBOARD: title}</h3>

    {DASHBOARD: nav}
    <br />
    <div>
';

$VSTORE_DASHBOARD_TEMPLATE['footer'] = '
    </div>
';


/**
 * Dashboard
 */
$VSTORE_DASHBOARD_TEMPLATE['dashboard'] = '
    <p>From your account dashboard you can view your recent orders, manage your shipping and billing addresses and edit your password and account details.</p>
';


/**
 * List orders
 */
$VSTORE_DASHBOARD_TEMPLATE['order']['list']['header'] = '
    <table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>Order info</th>
        <th>Shipping</th>
        <th>Items</th>
        <th>Total</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
';


$VSTORE_DASHBOARD_TEMPLATE['order']['list']['footer'] = '
    </tbody>
    </table>
';


$VSTORE_DASHBOARD_TEMPLATE['order']['list']['item'] = '
    <tr>
        <td>
            Date: {ORDER_DATA: order_date}<br />
            Order: {ORDER_DATA: order_ref}<br/>
            Invoice: {ORDER_DATA: order_invoice_nr}
        </td>
        <td>{ORDER_DATA: order_shipping_full}</td>
        <td>{ORDER_DATA: order_items_short}</td>
        <td>{ORDER_DATA: order_pay_amount}</td>
        <td>{ORDER_DATA: order_status_label}</td>
        <td>{ORDER_ACTIONS}</td>
    </tr>
';


/**
 * Order detail
 */
$VSTORE_DASHBOARD_TEMPLATE['order']['detail'] = '
    <h4>Order details {ORDER_DATA: order_ref} <span class="pull-right float-right">{ORDER_DATA: order_status_label}</span></h4>
    <div class="clearfix">
        <div class="col-sm-4">
            <b>Date</b> {ORDER_DATA: order_date}<br />
            <b>Order</b> {ORDER_DATA: order_ref}<br/>
            <b>Invoice</b> {ORDER_DATA: order_invoice_nr}<br/>
            <b>Payment method</b> {ORDER_DATA: order_gateway}<br/>
            <b>Payment complete</b> {ORDER_DATA: order_pay_status}<br/>
        </div>

        <div class="col-sm-4">
            <b>Shipping address</b> <br />
            {ORDER_DATA: order_shipping_full}<br/>
        </div>

        <div class="col-sm-4">
            <b>Billling address</b> <br />
            {ORDER_DATA: order_billing_full}<br/>
        </div>
    </div>

    <br />

    <div>
        <b>Items</b>
        {ORDER_ITEMS}
    </div>

    <div>
        <b>Log</b>
        {ORDER_DATA: order_log}
    </div>

    <hr />

    <div class="text-center">
        {ORDER_ACTIONS: cancel}
    </div>
';


/**
 * List downloads
 */
$VSTORE_DASHBOARD_TEMPLATE['download']['list']['header'] = '
    <table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>Order info</th>
        <th>Items</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
';


$VSTORE_DASHBOARD_TEMPLATE['download']['list']['footer'] = '
    </tbody>
    </table>
';


$VSTORE_DASHBOARD_TEMPLATE['download']['list']['item'] = '
    <tr>
        <td>
            Date: {ORDER_DATA: order_date}<br />
            Order: {ORDER_DATA: order_ref}<br/>
            Invoice: {ORDER_DATA: order_invoice_nr}
        </td>
        <td>{ORDER_DATA: order_downloads}</td>
        <td>{ORDER_DATA: order_status_label}</td>
    </tr>
';


/**
 * List downloads
 */
$VSTORE_DASHBOARD_TEMPLATE['address']['view'] = '

    <div class="col-12 col-xs-12 col-sm-6">
        <h4>Billing</h4>

        {DASHBOARD: billing_address}

        <br />
        {DASHBOARD: edit_billing}
    </div>

    <div class="col-12 col-xs-12 col-sm-6">
        <h4>Shipping</h4>

        {DASHBOARD: shipping_address}

        <br />
        {DASHBOARD: edit_shipping}
    </div>
    

';
