

<table class="table table-striped table-sm">
    <tr>
      <td>Company Name </td>
      <td><?=$company->name;?></td>
    </tr>
   
    <tr>
      <td>Legal Form</td>
      <td><?=$company->DecodedLegalForm;?></td>
    </tr>
    <tr>
      <td>Office Email</td>
      <td><?=$company->office_email;?> <?=$company->emailVerificationStatus;?></td>
    </tr>
    <tr>
      <td>Office Phone</td>
      <td><?=$company->office_phone;?> <?=$company->phoneVerificationStatus;?></td>
    </tr>
    <tr>
      <td>Address</td>
      <td><?=$company->fullAddress;?></td>
    </tr>
   
   <tr>
     <td>Post Code</td>
     <td><?=$company->addressArray['post_code'] ?? '';?></td>
   </tr>
    <tr>
      <td>IBAN</td>
      <td><?=$company->iban_number;?></td>
    </tr>
   
    <tr>
      <td>VAT Number</td>
      <td><?=$company->vat_number;?></td>
    </tr>
   
    <tr>
      <td>Created date</td>
      <td><?=date("M j, Y h:iA", strtotime($company->created_at));?></td>
    </tr>
</table>
