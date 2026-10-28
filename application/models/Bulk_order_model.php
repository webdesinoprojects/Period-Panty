<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_order_model extends CI_Model
{
    const CATEGORIES = array('Bamboo', 'Seamless', 'Cotton', 'Combo', 'Teen', 'Mixed categories');
    const SIZES = array('XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'XXXXL', 'XXXXXL', 'XXXXXXL', 'Mixed / advise me');

    public function validate($input)
    {
        $data = array(); $errors = array();
        $limits = array('name' => 200, 'company' => 200, 'email' => 254, 'mobile' => 30, 'category' => 40,
            'quantity' => 7, 'colours' => 200, 'city' => 120, 'postcode' => 12, 'address' => 1000,
            'needed_by' => 10, 'notes' => 3000);
        foreach ($limits as $field => $limit) {
            $value = isset($input[$field]) ? $input[$field] : '';
            if (!is_string($value) || !preg_match('//u', $value) || strlen($value) > $limit || strpos($value, "\0") !== FALSE) {
                $errors[$field] = 'Please enter valid ' . str_replace('_', ' ', $field) . '.';
                $data[$field] = '';
            } else { $data[$field] = trim($value); }
        }
        if (strlen($data['name']) < 2 || !preg_match('/\p{L}/u', $data['name'])) { $errors['name'] = 'Please enter your name.'; }
        $phone = $this->user_model->normalise_phone($data['mobile']);
        if (!$phone) { $errors['mobile'] = 'Enter a valid 10-digit Indian phone number.'; }
        else { $data['mobile'] = $phone; }
        if ($data['email'] !== '' && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) { $errors['email'] = 'Please enter a valid email address, or leave it blank.'; }
        if (!in_array($data['category'], self::CATEGORIES, TRUE)) { $errors['category'] = 'Choose a product category.'; }
        if (!ctype_digit($data['quantity']) || (int) $data['quantity'] < 1 || (int) $data['quantity'] > 1000000) { $errors['quantity'] = 'Enter the number of pieces needed, between 1 and 1,000,000.'; }
        if ($data['colours'] === '') { $errors['colours'] = 'Tell us which colours you need, or write Mixed.'; }
        if ($data['city'] === '') { $errors['city'] = 'Please enter your delivery city.'; }
        if ($data['postcode'] !== '' && !preg_match('/^[1-9][0-9]{5}$/D', $data['postcode'])) { $errors['postcode'] = 'Enter a valid 6-digit PIN code, or leave it blank.'; }
        $sizes = isset($input['sizes']) ? $input['sizes'] : array();
        $data['sizes'] = array();
        if (!is_array($sizes) || count($sizes) < 1 || count($sizes) > count(self::SIZES)) {
            $errors['sizes'] = 'Choose at least one size, or Mixed / advise me.';
        } else {
            foreach ($sizes as $size) {
                if (!is_string($size) || !in_array($size, self::SIZES, TRUE)) { $errors['sizes'] = 'Choose valid sizes from the list.'; }
                else { $data['sizes'][] = $size; }
            }
            $data['sizes'] = array_values(array_unique($data['sizes']));
        }
        if ($data['needed_by'] !== '') {
            $date = DateTime::createFromFormat('!Y-m-d', $data['needed_by']);
            if (!$date || $date->format('Y-m-d') !== $data['needed_by'] || $data['needed_by'] < date('Y-m-d')) {
                $errors['needed_by'] = 'Choose today or a future delivery date.';
            }
        }
        return array('data' => $data, 'errors' => $errors);
    }

    public function enquiry($data)
    {
        $message = 'BULK ORDER ENQUIRY (quotation request, not a placed order)' . "\n\n";
        $labels = array('company' => 'Company / organisation', 'category' => 'Category', 'quantity' => 'Quantity (pieces)',
            'colours' => 'Preferred colours', 'city' => 'Delivery city', 'postcode' => 'PIN code', 'address' => 'Delivery address',
            'needed_by' => 'Requested delivery date', 'notes' => 'Size / colour breakdown and notes');
        $message .= 'Sizes: ' . implode(', ', $data['sizes']) . "\n";
        foreach ($labels as $key => $label) { $message .= $label . ': ' . ($data[$key] !== '' ? $data[$key] : 'Not specified') . "\n"; }
        return array('name' => $data['name'], 'email' => $data['email'], 'mobile' => $data['mobile'],
            'subject' => 'Bulk order: ' . $data['category'] . ' - ' . (int) $data['quantity'] . ' pieces',
            'message' => $message, 'address' => $data['address'], 'create_date' => date('Y-m-d H:i:s'), 'delivery_status' => 'pending');
    }
}
