<?php
// CLI only; deterministic fixtures, no database, network, email or saved enquiries.
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('BASEPATH', __DIR__);
class CI_Model { public $user_model; }
require __DIR__ . '/../../models/User_model.php';
require __DIR__ . '/../../models/Bulk_order_model.php';
$model = new Bulk_order_model();
$model->user_model = (new ReflectionClass('User_model'))->newInstanceWithoutConstructor();
$valid = array('name' => 'Test Buyer', 'mobile' => '+91 9876543210', 'email' => '', 'category' => 'Bamboo',
    'quantity' => '100', 'colours' => 'Black and maroon', 'city' => 'Gurgaon', 'sizes' => array('M', 'XL'));
$checks = 0;
$check = function ($condition, $message) use (&$checks) { $checks++; if (!$condition) { throw new RuntimeException($message); } };
$result = $model->validate($valid);
$check(!$result['errors'], 'Valid enquiry without email must work.');
$check($result['data']['mobile'] === '9876543210', 'Phone must be normalised.');
foreach (array('name' => array('', array('x'), str_repeat('x', 201), '123'), 'mobile' => array('', '1111111111', array('x')),
    'email' => array('bad email', array('x')), 'category' => array('High Waist', array('Bamboo')), 'quantity' => array('0','-1','1.5','1000001','1e3',array('100')),
    'colours' => array('',array('black')), 'city' => array('',array('Gurgaon')), 'sizes' => array(array(), 'M', array('INVALID'), array(array('M'))),
    'postcode' => array('012345','12345'), 'needed_by' => array('2000-01-01','2099-02-31')) as $field => $bad_values) {
    foreach ($bad_values as $bad) { $input = $valid; $input[$field] = $bad; $r = $model->validate($input); $check(isset($r['errors'][$field]), 'Invalid field accepted: ' . $field); }
}
foreach (Bulk_order_model::CATEGORIES as $category) { $input = $valid; $input['category'] = $category; $check(!$model->validate($input)['errors'], 'Category rejected: ' . $category); }
$input = $valid; $input['sizes'] = array('M', 'M', 'XL'); $r = $model->validate($input);
$check($r['data']['sizes'] === array('M', 'XL'), 'Duplicate sizes must be removed.');
$enquiry = $model->enquiry($result['data']);
$check(strpos($enquiry['subject'], 'Bulk order: Bamboo - 100 pieces') === 0, 'Bulk subject missing.');
$check(strpos($enquiry['message'], 'Sizes: M, XL') !== FALSE, 'Sizes missing from admin message.');
$check(strpos($enquiry['message'], 'Black and maroon') !== FALSE, 'Colours missing from admin message.');
$check($enquiry['delivery_status'] === 'pending', 'Notification status must begin pending.');
$check(!isset($enquiry['bulk_token']) && !isset($enquiry['website']), 'Anti-spam values must never be saved.');
echo 'PASS: ' . $checks . " bulk enquiry validation and persistence-payload checks.\n";
