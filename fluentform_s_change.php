<?php 
/**
 *
 * Plugin Name: Fluentform S Change
 * Description: Send email on failure redirect
 * Version: 1.0.0
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

add_action( 'fluentform_before_transaction_status_change', 'fsc_fluentform_s_change', 10, 3 );

function fsc_fluentform_s_change( $newStatus, $submission, $transaction_id ) {
  if ($newStatus == 'failed') {
    if ($submission->payment_method == 'chip') {
      $to = $submission->response['email'];
      $subject = $submission->response['subject'];
      // $submission->response['names']['first_name'];

      $transaction = wpFluent()->table('fluentform_transactions')
            ->where('id', $transaction_id)
            ->first();

      $url = 'https://gate.chip-in.asia/p/' . $transaction->charge_id . '/';

      wp_mail($to, $subject, $url);
    }
  }
}