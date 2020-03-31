<?php
use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $createBill= new Permission();
        $createBill->name = 'Add Bill';
        $createBill->slug = 'add-bill';
        $createBill->save();

        $editBill = new Permission();
        $editBill->name = 'Edit Bill';
        $editBill->slug = 'edit-bill';
        $editBill->save();

        $removeBill = new Permission();
        $removeBill->name = 'Remove Bill';
        $removeBill->slug = 'remove-bill';
        $removeBill->save();

        $payBill = new Permission();
        $payBill->name = 'Pay Bill';
        $payBill->slug = 'pay-bill';
        $payBill->save();

        $revertBill = new Permission();
        $revertBill->name = 'Revert Bill';
        $revertBill->slug = 'revert-bill';
        $revertBill->save();

        $viewBill = new Permission();
        $viewBill->name = 'View Bill';
        $viewBill->slug = 'view-bill';
        $viewBill->save();

        $viewBillPayment = new Permission();
        $viewBillPayment->name = 'View Bill Payment';
        $viewBillPayment->slug = 'view-bill-payment';
        $viewBillPayment->save();

        $newExpense = new Permission();
        $newExpense->name = 'Add New Expense';
        $newExpense->slug = 'add-expense';
        $newExpense->save();

        $editExpense = new Permission();
        $editExpense->name = 'Edit Expense';
        $editExpense->slug = 'edit-expense';
        $editExpense->save();

        $removeExpense = new Permission();
        $removeExpense->name = 'Remove Expense';
        $removeExpense->slug = 'remove-expense';
        $removeExpense->save();

        $editExpense = new Permission();
        $editExpense->name = 'Edit Expense';
        $editExpense->slug = 'edit-expense';
        $editExpense->save();

        $removeExpense = new Permission();
        $removeExpense->name = 'Remove Expense';
        $removeExpense->slug = 'remove-expense';
        $removeExpense->save();

        $payExpense = new Permission();
        $payExpense->name = 'Remove Expense';
        $payExpense->slug = 'pay-expense';
        $payExpense->save();

        $revertExpense = new Permission();
        $revertExpense->name = 'Revert Expense';
        $revertExpense->slug = 'revert-expense';
        $revertExpense->save();

        $viewExpense = new Permission();
        $viewExpense->name = 'View Expense';
        $viewExpense->slug = 'view-expense';
        $viewExpense->save();

        $viewExpensePayment = new Permission();
        $viewExpensePayment->name = 'View Expense Payment';
        $viewExpensePayment->slug = 'view-expense-payment';
        $viewExpensePayment->save();


        $addSite = new Permission();
        $addSite->name = 'Add New Site';
        $addSite->slug = 'add-new-site';
        $addSite->save();

        $editSite = new Permission();
        $editSite->name = 'Edit New Site';
        $editSite->slug = 'edit-new-site';
        $editSite->save();

        $removeSite = new Permission();
        $removeSite->name = 'Remove Site';
        $removeSite->slug = 'remove-new-site';
        $removeSite->save();


        $addMaterial = new Permission();
        $addMaterial->name = 'Add New Material';
        $addMaterial->slug = 'add-new-material';
        $addMaterial->save();

        $editMaterial = new Permission();
        $editMaterial->name = 'Add New Material';
        $editMaterial->slug = 'edit-new-material';
        $editMaterial->save();

        $removeMaterial = new Permission();
        $removeMaterial->name = 'Remove Material';
        $removeMaterial->slug = 'remove-new-site';
        $addMaterial->save();

        $addUser = new Permission();
        $addUser->name = 'Add New User';
        $addUser->slug = 'add-new-user';
        $addUser->save();

        $viewSite = new Permission();
        $viewSite->name = 'View Site';
        $viewSite->slug = 'view-new-site';
        $viewSite->save();

        
        $viewSite = new Permission();
        $viewSite->name = 'View Site';
        $viewSite->slug = 'view-new-site';
        $viewSite->save(); 
        
    }
}
