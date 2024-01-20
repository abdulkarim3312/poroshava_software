<?php

use App\Enumeration\Role;
use App\Http\Controllers\AutoRickshaw\AutoRickshawHomeController;
use App\Http\Controllers\AutoRickshaw\AutoRickshawTypeController;
use App\Http\Controllers\BalanceTransferController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CashbookReportController;
use App\Http\Controllers\Collection\CollectionAreaController;
use App\Http\Controllers\Collection\CollectionController;
use App\Http\Controllers\Collection\CollectionSubTypeController;
use App\Http\Controllers\Collection\CollectionTypeController;
use App\Http\Controllers\Collection\CollectionReportController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HRPayrollReportController;
use App\Http\Controllers\IncomeExpenditureController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\SectorTypeController;
use App\Http\Controllers\SubSectorTypeController;
use App\Http\Controllers\Sweeper\AreaController;
use App\Http\Controllers\Sweeper\CleanerController;
use App\Http\Controllers\Sweeper\SweeperBonusController;
use App\Http\Controllers\Sweeper\SweeperCommonController;
use App\Http\Controllers\Sweeper\SweeperReportController;
use App\Http\Controllers\Sweeper\SweeperSalaryController;
use App\Http\Controllers\Sweeper\TeamController;
use App\Http\Controllers\Sweeper\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Holding\TaxPayerController;
use App\Http\Controllers\Holding\HoldingAreaController;
use App\Http\Controllers\Holding\HoldingInstallmentController;
use App\Http\Controllers\Holding\HoldingUseTypeController;
use App\Http\Controllers\Holding\StructureTypeController;
use App\Http\Controllers\Holding\HoldingCategoryController;
use App\Http\Controllers\Holding\HoldingCommonController;
use App\Http\Controllers\TradeLicense\TradeLicenseAreaController;
use App\Http\Controllers\TradeLicense\TradeLicenseBusinessTypeController;
use App\Http\Controllers\TradeLicense\TradeLicenseSignBoardController;
use App\Http\Controllers\TradeLicense\TradeInfoController;
use App\Http\Controllers\TradeLicense\TradeLicenseController;
use App\Http\Controllers\TradeLicense\TradeCommonController;
use App\Models\SisterConcern;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    return redirect()->route('login');
});

//Route::get('login-new', [DashboardController::class, 'loginNew']);
//Route::get('forgot-password-new', [DashboardController::class, 'forgotPassword'])->name('password.forgot');
//Route::get('reset-password-new/{token}', [DashboardController::class, 'resetPassword'])->name('password.new.reset');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')
    ->middleware('auth');

Route::middleware(['auth'])->group(function() {
    Route::get('/module', function () {
        $sisterConcerns = SisterConcern::orderBy('sort')->where('status',1)->get();
        return view('admin_dashboard',compact('sisterConcerns'));

    })->name('module');
    // User
        Route::get('user', [UserController::class, 'index'])->name('user');
        Route::get('user-datatable', [UserController::class, 'datatable'])->name('user.datatable');
        Route::get('user/add', [UserController::class, 'add'])->name('user.add');
        Route::post('user/add', [UserController::class, 'addPost']);
        Route::get('user/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('user/edit/{user}', [UserController::class, 'editPost']);

    });



Route::middleware('auth')->group(function () {
    Route::middleware(['role:'.Role::$ACCOUNTS.'-'.Role::$CASH_BOOK])->group(function () {

        //Sector Type
        Route::get('sector-type', [SectorTypeController::class, 'index'])->name('sector_type');
        Route::get('sector-type/create', [SectorTypeController::class, 'create'])->name('sector_type.create');
        Route::post('sector-type/create', [SectorTypeController::class, 'store']);
        Route::get('sector-type/edit/{sectorType}', [SectorTypeController::class, 'edit'])->name('sector_type.edit');
        Route::post('sector-type/edit/{sectorType}', [SectorTypeController::class, 'update']);
        Route::get('sector-type-datatable', [SectorTypeController::class, 'datatable'])->name('sector_type.datatable');

        //Sub Sector Type
        Route::get('sub-sector-type', [SubSectorTypeController::class, 'index'])->name('sub_sector_type');
        Route::get('sub-sector-type/create', [SubSectorTypeController::class, 'create'])->name('sub_sector_type.create');
        Route::post('sub-sector-type/create', [SubSectorTypeController::class, 'store']);
        Route::get('sub-sector-type/edit/{sectorType}', [SubSectorTypeController::class, 'edit'])->name('sub_sector_type.edit');
        Route::post('sub-sector-type/edit/{sectorType}', [SubSectorTypeController::class, 'update']);
        Route::get('sub-sector-type-datatable', [SubSectorTypeController::class, 'datatable'])->name('sub_sector_type.datatable');

        //Sector
        Route::get('sector', [SectorController::class, 'index'])->name('sector');
        Route::get('sector/create', [SectorController::class, 'create'])->name('sector.create');
        Route::post('sector/create', [SectorController::class, 'store']);
        Route::get('sector/edit/{sector}', [SectorController::class, 'edit'])->name('sector.edit');
        Route::post('sector/edit/{sector}', [SectorController::class, 'update']);
        Route::get('sector-datatable', [SectorController::class, 'datatable'])->name('sector.datatable');
    });
    Route::middleware(['role:'.Role::$ACCOUNTS])->group(function () {

        //section
        Route::get('section', [SectionController::class, 'index'])->name('section');
        Route::get('section/create', [SectionController::class, 'create'])->name('section.create');
        Route::post('section/create', [SectionController::class, 'store']);
        Route::get('section/edit/{upangsho}', [SectionController::class, 'edit'])->name('section.edit');
        Route::post('section/edit/{upangsho}', [SectionController::class, 'update']);

        //Bank
        Route::get('bank', [BankController::class, 'index'])->name('bank');
        Route::get('bank/create', [BankController::class, 'create'])->name('bank.create');
        Route::post('bank/create', [BankController::class, 'store']);
        Route::get('bank/edit/{bank}', [BankController::class, 'edit'])->name('bank.edit');
        Route::post('bank/edit/{bank}', [BankController::class, 'update']);
        //Branch
        Route::get('branch', [BranchController::class, 'index'])->name('branch');
        Route::get('branch/create', [BranchController::class, 'create'])->name('branch.create');
        Route::post('branch/create', [BranchController::class, 'store']);
        Route::get('branch/edit/{branch}', [BranchController::class, 'edit'])->name('branch.edit');
        Route::post('branch/edit/{branch}', [BranchController::class, 'update']);
        //Bank Account
        Route::get('bank-account', [BankAccountController::class, 'index'])->name('bank_account');
        Route::get('bank-account/create', [BankAccountController::class, 'create'])->name('bank_account.create');
        Route::post('bank-account/create', [BankAccountController::class, 'store']);
        Route::get('bank-account/edit/{bankAccount}', [BankAccountController::class, 'edit'])->name('bank_account.edit');
        Route::post('bank-account/edit/{bankAccount}', [BankAccountController::class, 'update']);

        //Contractor
        Route::get('contractor', [ContractorController::class, 'index'])->name('contractor');
        Route::get('contractor-datatable', [ContractorController::class, 'datatable'])->name('contractor.datatable');
        Route::get('contractor/create', [ContractorController::class, 'create'])->name('contractor.create');
        Route::post('contractor/create', [ContractorController::class, 'store']);
        Route::get('contractor/edit/{contractor}', [ContractorController::class, 'edit'])->name('contractor.edit');
        Route::post('contractor/edit/{contractor}', [ContractorController::class, 'update']);

        //Project
        Route::get('project/create', [ProjectController::class, 'create'])->name('project.create');
        Route::post('project/create', [ProjectController::class, 'store']);
        Route::get('project/payment-list', [ProjectController::class, 'paymentList'])->name('project_payment_list');
        Route::get('project/payment-list/datatable', [ProjectController::class, 'paymentListDatatable'])->name('project_payment_list.datatable');
        Route::get('project/contractor/payment/{contractorAccount}', [ProjectController::class, 'payment'])->name('project.contractor_payment');
        Route::post('project/contractor/payment/{contractorAccount}', [ProjectController::class, 'paymentPost']);
        //Project Report
        Route::get('report/project-payment-register', [ReportController::class, 'projectPaymentRegister'])->name('report.project_payment_register');
        Route::get('report/project-payment-certificate', [ReportController::class, 'projectPaymentCertificate'])->name('report.project_payment_certificate');

        //Budget
        Route::get('budget', [BudgetController::class, 'index'])->name('budget');
        Route::get('budget/create', [BudgetController::class, 'create'])->name('budget.create');
        Route::post('budget/create', [BudgetController::class, 'store']);
        Route::post('budget/update', [BudgetController::class, 'update'])->name('budget_update');
        Route::get('budget-datatable', [BudgetController::class, 'datatable'])->name('budget.datatable');
        Route::get('budget/pending-list', [BudgetController::class, 'pendingList'])->name('budget.pending_list');
        Route::post('budget/approved', [BudgetController::class, 'approved'])->name('budget_approved');
        Route::get('budget-pending-datatable', [BudgetController::class, 'pendingDatatable'])->name('budget_pending.datatable');

        Route::group(['prefix' => '/'],function(){

            Route::resource('badget_register', ReportController::class);
        });

        //income-expenditure
        Route::get('income-expenditure', [IncomeExpenditureController::class, 'index'])->name('income_expenditure');
        Route::get('income-expenditure/datatable', [IncomeExpenditureController::class, 'datatable'])->name('income_expenditure.datatable');
        Route::get('income-expenditure/create', [IncomeExpenditureController::class, 'create'])->name('income_expenditure.create');
        Route::post('income-expenditure/create', [IncomeExpenditureController::class, 'store']);
        Route::post('income-expenditure/update', [IncomeExpenditureController::class, 'update'])->name('income_expenditure.update');
        Route::post('income-expenditure/delete', [IncomeExpenditureController::class, 'destroy'])->name('income_expenditure.delete');

        //Cheque Register

        Route::get('report/cheque-register', [ReportController::class, 'chequeRegister'])->name('report.cheque_register');
        Route::post('cheque-register-allow-all', [ReportController::class, 'chequeRegisterAllowAll'])->name('cheque_register.allow_all');
        Route::post('cheque-register-allow', [ReportController::class, 'chequeRegisterAllow'])->name('cheque_register.allow');
        Route::post('cheque-register-delete', [ReportController::class, 'chequeRegisterDelete'])->name('cheque_register.delete');
        Route::get('cheque-register-print/{incomeExpense}', [ReportController::class, 'chequeRegisterPrint'])->name('cheque_register.print');
        Route::post('cheque-register-details', [ReportController::class, 'chequeRegisterDetails'])->name('cheque_register.details');
        Route::post('cheque-register-update', [ReportController::class, 'chequeRegisterUpdate'])->name('cheque_register.update');
        Route::get('cheque-register/cheque-print/{incomeExpense}', [ReportController::class, 'chequePrint'])->name('cheque_register.cheque_print');
        Route::get('challan-print/{incomeExpense}', [ReportController::class, 'challanPrint'])->name('challan_print');

        //Balance Transfer
        Route::get('balance-transfer', [BalanceTransferController::class, 'create'])->name('balance_transfer');
        Route::post('balance-transfer', [BalanceTransferController::class, 'store']);

        //Reports
        Route::get('report/income-uncash', [ReportController::class, 'incomeUncash'])->name('report.income_uncash');
        Route::get('report/expense-uncash', [ReportController::class, 'expenseUncash'])->name('report.expense_uncash');
        Route::post('cashbook-expense-uncash_confirm', [ReportController::class, 'cashbookExpenseUnCashConfirm'])->name('cashbook_expense.uncash_confirm');
        Route::get('report/cashbook', [ReportController::class, 'cashbook'])->name('report.cashbook');
        Route::get('report/cashbook-expense', [ReportController::class, 'cashbookExpense'])->name('report.cashbook_expense');
        Route::post('report/cashbook-expense/cash-confirm', [ReportController::class, 'cashbookExpenseCashConfirm'])->name('report.cashbook_expense.cash_confirm');
        Route::get('report/cashbook-income', [ReportController::class, 'cashbookIncome'])->name('report.cashbook_income');
        Route::get('report/bank-account-closing', [ReportController::class, 'bankAccountClosing'])->name('report.bank_account_closing');
        Route::get('report/income-expenditure', [ReportController::class, 'incomeExpenditure'])->name('report.income_expenditure');

        Route::get('report/yearly-income-expenditure', [ReportController::class, 'yearlyIncomeExpenditure'])->name('report.yearly_income_expenditure');

        Route::get('report/daily-income-expenditure', [ReportController::class, 'dailyIncomeExpenditure'])->name('report.daily_income_expenditure');

        Route::get('report/income-budget', [ReportController::class, 'incomeBudget'])->name('report.income_budget');

        Route::get('report/expenditure-budget', [ReportController::class, 'expenditureBudget'])->name('report.expenditure_budget');

        Route::get('report/bank-details-report', [ReportController::class, 'bankDetailsReport'])->name('report.bank_details_report');


        // Route::get('yearly_balance_sheet', [ReportController::class, 'yearlyBalanceSheet'])->middleware('auth');
        // Route::post('yearly_balance_sheet', [ReportController::class, 'yearlyBalanceSheetPost'])->name('yearly_balancesheet.post')->middleware('auth');
        // Route::group(['prefix' => '/income_expenditure_amount'],function(){

        //     Route::resource('', ReportController::class)->middleware('auth');

        // });



        Route::get('notification', [NotificationController::class, 'notification'])->name('notification');
        Route::get('notification/mark-read', [NotificationController::class, 'markRead'])->name('notification_mark_read');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    });
    //Common
    Route::get('get_contractor_wise_projects', [CommonController::class, 'getContractorWiseProjects'])->name('get_contractor_wise_projects');
    Route::get('get_branches', [CommonController::class, 'getBranches'])->name('get_branches');
    Route::get('get_bank_accounts', [CommonController::class, 'getBankAccounts'])->name('get_bank_accounts');
    Route::get('get_sector_types', [CommonController::class, 'getSectorTypes'])->name('get_sector_types');
    Route::get('get_upangsho_wise_sector_types', [CommonController::class, 'getUpangshoWiseSectorTypes'])->name('get_upangsho_wise_sector_types');
    Route::get('get_sub_sector_types', [CommonController::class, 'getSubSectorTypes'])->name('get_sub_sector_types');
    Route::get('get_upangsho_income_expenditure_sub_sector_types', [CommonController::class, 'getUpangshoIncomeExpenditureSubSectorTypes'])->name('get_upangsho_income_expenditure_sub_sector_types');
    Route::get('get_sectors', [CommonController::class, 'getSector'])->name('get_sectors');
    Route::get('get_cashbook_sectors', [CommonController::class, 'getCashbookSector'])->name('get_cashbook_sectors');
    Route::get('get_cashbook_sector_details', [CommonController::class, 'getCashbookSectorDetails'])->name('get_cashbook_sector_details');
    Route::get('check-budget', [CommonController::class, 'checkBudget'])->name('check_budget');

    Route::middleware(['role:'.Role::$HR_PAYROLL])->group(function () {
        Route::get('employee', [EmployeeController::class, 'index'])->name('employee');
        Route::get('employee-datatable', [EmployeeController::class, 'datatable'])->name('employee.datatable');
        Route::get('employee/create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::post('employee/create', [EmployeeController::class, 'store']);
        Route::get('employee/edit/{employee}', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::post('employee/edit/{employee}', [EmployeeController::class, 'update']);
        //Loan
        Route::get('loan-process', [LoanController::class, 'loanProcess'])->name('loan_process');
        Route::post('loan-process', [LoanController::class, 'loanProcessPost']);
        Route::get('loan', [LoanController::class, 'index'])->name('loan');
        Route::get('loan-datatable', [LoanController::class, 'datatable'])->name('loan.datatable');
        //Salary
        Route::get('employee-salary-update-list', [SalaryController::class, 'index'])->name('employee_salary_update_list');
        Route::get('employee-salary-edit/{employee}', [SalaryController::class, 'salaryEdit'])->name('employee_salary_edit');
        Route::post('employee-salary-edit/{employee}', [SalaryController::class, 'salaryStore']);
        Route::get('employee-salary-update-datatable', [SalaryController::class, 'datatable'])->name('employee_salary_update.datatable');

        Route::get('employee-salary-process', [SalaryController::class, 'salaryProcess'])->name('employee_salary_process');
        Route::get('employee-salary-deposit', [SalaryController::class, 'salaryDeposit'])->name('employee_salary_deposit');
        Route::get('employee-pf-deposit', [SalaryController::class, 'pfDeposit'])->name('employee_pf_deposit');
        Route::get('employee-gratuity-deposit', [SalaryController::class, 'gratuityDeposit'])->name('employee_gratuity_deposit');
        //Bonus
        Route::get('employee-bonus-process', [SalaryController::class, 'bonusProcess'])->name('employee_bonus_process');

        //Report
        Route::get('report/employee-monthly-pay-bill', [HRPayrollReportController::class, 'monthlyPayBill'])->name('report.employee_monthly_pay_bill');
        Route::get('report/employee-monthly-salary-top-sheet', [HRPayrollReportController::class, 'monthlySalaryTopSheet'])->name('report.employee_monthly_salary_top_sheet');
        Route::get('report/employee-monthly-salary-bank-deposit', [HRPayrollReportController::class, 'monthlyBankDeposit'])->name('report.employee_monthly_salary_bank_deposit');



        //Common Controller
        Route::get('get_department_wise_employees', [CommonController::class, 'getDepartmentWiseEmployees'])->name('get_department_wise_employees');
        Route::get('get_salary_process_months', [CommonController::class, 'getSalaryProcessMonths'])->name('get_salary_process_months');
        Route::get('get_salary_deposit_months', [CommonController::class, 'getSalaryDepositMonths'])->name('get_salary_deposit_months');
        Route::get('get_pf_deposit_months', [CommonController::class, 'getPfDepositMonths'])->name('get_pf_deposit_months');
        Route::get('get_gratuity_deposit_months', [CommonController::class, 'getGratuityDepositMonths'])->name('get_gratuity_deposit_months');
        Route::get('get_months', [CommonController::class, 'getMonths'])->name('get_months');
        Route::get('get_sections', [CommonController::class, 'getSections'])->name('get_sections');

    });

    Route::middleware(['role:'.Role::$SWEEPER_BILL])->prefix('sweeper')->group(function () {
        // Area
        Route::get('area', [AreaController::class,'index'])->name('area');
        Route::get('area/add', [AreaController::class,'add'])->name('area.add');
        Route::post('area/add', [AreaController::class,'addPost']);
        Route::get('area/edit/{area}', [AreaController::class,'edit'])->name('area.edit');
        Route::post('area/edit/{area}', [AreaController::class,'editPost']);

        // Team
        Route::get('team', [TeamController::class,'index'])->name('team');
        Route::get('team/add', [TeamController::class,'add'])->name('team.add');
        Route::post('team/add', [TeamController::class,'addPost']);
        Route::get('team/edit/{team}', [TeamController::class,'edit'])->name('team.edit');
        Route::post('team/edit/{team}', [TeamController::class,'editPost']);

        // Type
        Route::get('type', [TypeController::class,'index'])->name('type');
        Route::get('type/add', [TypeController::class,'add'])->name('type.add');
        Route::post('type/add', [TypeController::class,'addPost']);
        Route::get('type/edit/{type}', [TypeController::class,'edit'])->name('type.edit');
        Route::post('type/edit/{type}', [TypeController::class,'editPost']);

        // Cleaner
        Route::get('cleaner', [CleanerController::class,'index'])->name('cleaner');
        Route::get('cleaner-datatable', [CleanerController::class,'cleanerDatatable'])->name('cleaner_datatable');
        Route::get('cleaner/add', [CleanerController::class,'add'])->name('cleaner.add');
        Route::post('cleaner/add', [CleanerController::class,'addPost']);
        Route::get('cleaner/edit/{cleaner}', [CleanerController::class,'edit'])->name('cleaner.edit');
        Route::post('cleaner/edit/{cleaner}', [CleanerController::class,'editPost']);

        // Cleaner Salary
        Route::get('cleaner/salary-update', [SweeperSalaryController::class,'cleanerSalaryUpdate'])->name('cleaner_salary_update');
        Route::post('cleaner/salary-update', [SweeperSalaryController::class,'cleanerSalaryUpdatePost']);
        Route::post('cleaner/bonus-update', [SweeperSalaryController::class,'cleanerBonusUpdatePost'])->name('cleaner_bonus_update');

        // Cleaner Salary Process
        Route::get('cleaner/salary-process', [SweeperSalaryController::class,'cleanerSalaryProcess'])->name('cleaner_salary_process');
        Route::post('process-salary-update', [SweeperSalaryController::class, 'processSalaryUpdate'])->name('process_salary_update');
        // Cleaner Bonus Process
        Route::get('cleaner/bonus-process', [SweeperBonusController::class,'cleanerBonusProcess'])->name('cleaner_bonus_process');

        //Report

        Route::get('report/bonus', [SweeperReportController::class,'bonus'])->name('bonus');
        Route::get('report/monthly-bill', [SweeperReportController::class,'monthlyBill'])->name('monthly_bill');
        Route::get('report/bi-monthly-bill', [SweeperReportController::class,'biMonthlyBill'])->name('bi_monthly_bill');
        Route::get('report/salary-top-sheets', [SweeperReportController::class,'salaryTopSheets'])->name('salary_top_sheets');
        Route::get('report/bonus-top-sheets', [SweeperReportController::class,'bonusTopSheets'])->name('bonus_top_sheets');
        Route::get('report/cleaner-information', [SweeperReportController::class,'cleanerInformation'])->name('cleaner_information');


        //Common operation
        Route::get('get-team', [SweeperCommonController::class,'getTeam'])->name('get_team');
        Route::get('get-cleaner', [SweeperCommonController::class,'getCleaner'])->name('get_cleaner');
        Route::get('get-month', [SweeperCommonController::class,'getMonth'])->name('get_month');
        Route::get('get-salary-process-month', [SweeperCommonController::class,'getSalaryProcessMonth'])->name('get_salary_process_month');
        Route::get('get-bi-month', [SweeperCommonController::class,'getBiMonth'])->name('get_bi_month');
        Route::get('get-salary-process-bi-month', [SweeperCommonController::class,'getSalaryProcessBiMonth'])->name('get_salary_process_bi_month');

    });

    Route::middleware(['role:'.Role::$CASH_BOOK])->prefix('cashbook')->group(function () {


        Route::get('cashbook-income/create', [CashbookReportController::class,'income'])->name('cashbook_income.create');
        Route::post('cashbook-income/create', [CashbookReportController::class,'incomePost']);

        //Report
        Route::get('report/treasurer-cashbook', [CashbookReportController::class,'treasurerCashbook'])->name('report.treasurer_cashbook');
        Route::get('report/abstract-register', [CashbookReportController::class,'abstractRegister'])->name('report.abstract_register');
    });

    Route::middleware(['role:'.Role::$HOLDING_TAX])->prefix('holding')->group(function () {

        // Area
        Route::get('area', [HoldingAreaController::class,'index'])->name('holding.area');
        Route::get('area/add', [HoldingAreaController::class,'add'])->name('holding.area.add');
        Route::post('area/add', [HoldingAreaController::class,'addPost']);
        Route::get('area/edit/{area}', [HoldingAreaController::class,'edit'])->name('holding.area.edit');
        Route::post('area/edit/{area}', [HoldingAreaController::class,'editPost']);
        Route::post('area/delete', [HoldingAreaController::class,'delete'])->name('holding.area.delete');

        // Holding Category
        Route::get('holding/category', [HoldingCategoryController::class,'index'])->name('holding.holding_category');
        Route::get('holding/category/add', [HoldingCategoryController::class,'add'])->name('holding.holding_category.add');
        Route::post('holding/category/add', [HoldingCategoryController::class,'addPost']);
        Route::get('holding/category/edit/{holdingCategory}', [HoldingCategoryController::class,'edit'])->name('holding.holding_category.edit');
        Route::post('holding/category/edit/{holdingCategory}', [HoldingCategoryController::class,'editPost']);
        Route::post('holding/category/delete', [HoldingCategoryController::class,'delete'])->name('holding.holding_category.delete');

        // Holding use type
        Route::get('use/type', [HoldingUseTypeController::class,'index'])->name('holding.use_type');
        Route::get('use/type/add', [HoldingUseTypeController::class,'add'])->name('holding.use_type.add');
        Route::post('use/type/add', [HoldingUseTypeController::class,'addPost']);
        Route::get('use/type/edit/{holdingUseType}', [HoldingUseTypeController::class,'edit'])->name('holding.use_type.edit');
        Route::post('use/type/edit/{holdingUseType}', [HoldingUseTypeController::class,'editPost']);

        // structure type
        Route::get('structure/type', [StructureTypeController::class,'index'])->name('holding.structure_type');
        Route::get('structure/type/add', [StructureTypeController::class,'add'])->name('holding.structure_type.add');
        Route::post('structure/type/add', [StructureTypeController::class,'addPost']);
        Route::get('structure/type/edit/{structureType}', [StructureTypeController::class,'edit'])->name('holding.structure_type.edit');
        Route::post('structure/type/edit/{structureType}', [StructureTypeController::class,'editPost']);
        Route::post('structure/type/delete', [StructureTypeController::class,'delete'])->name('holding.structure_type.delete');

        // tax-payer
        Route::get('tax-payer', [TaxPayerController::class,'index'])->name('holding.tax_payer');
        Route::get('tax-payer-datatable/{area?}/{name?}', [TaxPayerController::class,'datatable'])->name('holding_tax_payer_datatable');
        Route::get('tax-payer/add', [TaxPayerController::class,'add'])->name('holding.tax_payer.add');
        Route::post('tax-payer/add', [TaxPayerController::class,'addPost']);
        Route::get('tax-payer/edit/{payer}', [TaxPayerController::class,'edit'])->name('holding.tax_payer.edit');
        Route::post('tax-payer/edit/{payer}', [TaxPayerController::class,'editPost']);
        Route::get('tax-payer/details/add/{holdingTaxPayer}', [TaxPayerController::class,'taxPayerDetailsAdd'])->name('holding.tax_payer_details.add');
        Route::get('tax-payer/view-details/{holdingAssessment}', [TaxPayerController::class,'taxPayerAssessmentDetails'])->name('holding_tax_payer_assesment_details');

        //tax-payer All info
        Route::get('tax-payer/holdinginfo/{holdingTaxPayer}', [TaxPayerController::class,'holdinginfoAdd'])->name('holding_tax_payer_holdinginfo');
        Route::post('tax-payer/holdinginfo/{holdingTaxPayer}', [TaxPayerController::class,'holdinginfoAddPost']);
        Route::get('tax-payer/construction/{holdingTaxPayer}', [TaxPayerController::class,'constructionAdd'])->name('holding_tax_payer_construction');
        Route::post('tax-payer/construction/{holdingTaxPayer}', [TaxPayerController::class,'constructionAddPost']);
        Route::get('tax-payer/tenant/{holdingTaxPayer}', [TaxPayerController::class,'tenantAdd'])->name('holding_tax_payer_tenant');
        Route::post('tax-payer/tenant/{holdingTaxPayer}', [TaxPayerController::class,'tenantAddPost']);


        Route::post('/holding/add', [HoldingCommonController::class, 'holdingInfoUpdate'])->name('holdingInfo_Update');
        Route::post('tax-payer-structure-add', [HoldingCommonController::class,'taxPayerStructureAdd'])->name('holding_tax_payer_structure_add');
        Route::post('tax-payer-structure-edit', [HoldingCommonController::class,'taxPayerStructureEdit'])->name('holding_tax_payer_structure_edit');
        Route::post('tax-payer-tenant-add', [HoldingCommonController::class,'taxPayerTenantAdd'])->name('holding_tax_payer_tenant_add');
        Route::post('tax-payer-tenant-edit', [HoldingCommonController::class,'taxPayerTenantEdit'])->name('holding_tax_payer_tenant_edit');
        Route::get('get-structure-template-details', [HoldingCommonController::class,'getStructureTemplateDetails'])->name('get_structure_template_details');
        Route::get('get-tenant-template-details', [HoldingCommonController::class,'getTenantTemplateDetails'])->name('get_tenant_template_details');
        Route::post('assessment-submit-and-calculation', [HoldingCommonController::class,'assessmentSubmitAndCalculation'])->name('assessment_submit_and_calculation');

        // installment Process
        Route::get('installment/process', [HoldingInstallmentController::class,'index'])->name('holding.installment_process');
        Route::post('installment/process/post', [HoldingInstallmentController::class,'process'])->name('installment_process.post');

        // Collection Posting
        Route::get('collection-posting', [AreaController::class,'index'])->name('holding.collection_posting');

        //Report
        Route::get('report/treasurer-cashbook', [CashbookReportController::class,'treasurerCashbook'])->name('report.treasurer_cashbook');
        Route::get('report/abstract-register', [CashbookReportController::class,'abstractRegister'])->name('report.abstract_register');
    });

    Route::middleware(['role:'.Role::$TRADE_LICENSE])->prefix('trade-license')->group(function () {

        // Area
        Route::get('area', [TradeLicenseAreaController::class,'index'])->name('trade_license_area');
        Route::get('area/add', [TradeLicenseAreaController::class,'add'])->name('trade_license_area_add');
        Route::post('area/add', [TradeLicenseAreaController::class,'addPost']);
        Route::get('area/edit/{area}', [TradeLicenseAreaController::class,'edit'])->name('trade_license_area_edit');
        Route::post('area/edit/{area}', [TradeLicenseAreaController::class,'editPost']);
        Route::post('area/delete', [TradeLicenseAreaController::class,'delete'])->name('trade_license_area_delete');

        // Trade License Business type
        Route::get('business/type', [TradeLicenseBusinessTypeController::class,'index'])->name('trade_license_business_type');
        Route::get('business/type/add', [TradeLicenseBusinessTypeController::class,'add'])->name('trade_license_business_type_add');
        Route::post('business/type/add', [TradeLicenseBusinessTypeController::class,'addPost']);
        Route::get('business/type/edit/{businessType}', [TradeLicenseBusinessTypeController::class,'edit'])->name('trade_license_business_type_edit');
        Route::post('business/type/edit/{businessType}', [TradeLicenseBusinessTypeController::class,'editPost']);
        Route::post('business/type/delete', [TradeLicenseBusinessTypeController::class,'delete'])->name('trade_license_business_type_delete');

        // Trade License Signboard type
        Route::get('signboard', [TradeLicenseSignBoardController::class,'index'])->name('trade_license_signboard');
        Route::get('signboard/add', [TradeLicenseSignBoardController::class,'add'])->name('trade_license_signboard_add');
        Route::post('signboard/add', [TradeLicenseSignBoardController::class,'addPost']);
        Route::get('signboard/edit/{signboard}', [TradeLicenseSignBoardController::class,'edit'])->name('trade_license_signboard_edit');
        Route::post('signboard/edit/{signboard}', [TradeLicenseSignBoardController::class,'editPost']);
        Route::post('signboard/delete', [TradeLicenseSignBoardController::class,'delete'])->name('trade_license_signboard_delete');

        // Trade-License
        Route::get('trade-license/application', [TradeLicenseController::class,'add'])->name('trade_license_add');
        Route::post('trade-license/application', [TradeLicenseController::class,'addPost']);
        Route::post('trade-license/pending-update', [TradeLicenseController::class,'addPendingUpdate'])->name('trade_license_pending_update');
        Route::post('trade-license/add-license/{tradeUser}', [TradeLicenseController::class,'addLicense'])->name('trade_license_add_license');

        // Trade-License Info application
        Route::get('trade-license-list', [TradeInfoController::class,'index'])->name('trade_license_list');
        Route::get('trade-license-list-datatable', [TradeInfoController::class,'datatable'])->name('trade_license_list_datatable');
        Route::get('trade-license-approve-list', [TradeInfoController::class,'approveList'])->name('trade_license_approve_list');
        Route::get('trade-license-approve-list-datatable', [TradeInfoController::class,'approveListDatatable'])->name('trade_license_approve_list_datatable');
        Route::get('trade-license-pending-list', [TradeInfoController::class,'pendingList'])->name('trade_license_pending_list');
        Route::get('trade-license-pending-list-datatable', [TradeInfoController::class,'pendingListDatatable'])->name('trade_license_pending_list_datatable');
        Route::get('trade-license/edit/{payer}', [TradeInfoController::class,'edit'])->name('trade_license_edit');
        Route::post('trade-license/edit/{payer}', [TradeInfoController::class,'editPost']);
        Route::get('trade-license/details/{tradeUser}', [TradeInfoController::class,'tradeUserDetails'])->name('trade_license_details');
        Route::get('trade-license/approve-details/{tradeUser}', [TradeInfoController::class,'tradeUserApproveDetails'])->name('trade_license_approve_details');
        Route::get('trade-license/pending-details/{tradeUser}', [TradeInfoController::class,'tradeUserPendingDetails'])->name('trade_license_pending_details');

        //Trade License Bill
        Route::get('license/bill', [TradeLicenseController::class,'bill'])->name('trade_license_bill_view');

        //Common Route
        Route::get('holding_no_json', [TradeCommonController::class,'holdingNoJson'])->name('holding_no_json');
        Route::get('get_moholla', [TradeCommonController::class,'getMoholla'])->name('trade_license_get_moholla');
        Route::get('get_upazila', [TradeCommonController::class,'getUpazila'])->name('trade_license_get_upazila');
//        Route::post('/holding/add', [HoldingCommonController::class, 'holdingInfoUpdate'])->name('holdingInfo_Update');
//        Route::post('tax-payer-structure-add', [HoldingCommonController::class,'taxPayerStructureAdd'])->name('holding_tax_payer_structure_add');
//        Route::post('tax-payer-tenant-add', [HoldingCommonController::class,'taxPayerTenantAdd'])->name('holding_tax_payer_tenant_add');
//
//        // installment Process
//        Route::get('installment/process', [HoldingInstallmentController::class,'index'])->name('holding.installment_process');
//        Route::post('installment/process/post', [HoldingInstallmentController::class,'process'])->name('installment_process.post');
//
//        // Collection Posting
//        Route::get('collection-posting', [AreaController::class,'index'])->name('holding.collection_posting');
//
//        //Report
//        Route::get('report/treasurer-cashbook', [CashbookReportController::class,'treasurerCashbook'])->name('report.treasurer_cashbook');
//        Route::get('report/abstract-register', [CashbookReportController::class,'abstractRegister'])->name('report.abstract_register');
    });
    Route::middleware(['role:'.Role::$COLLECTION])->prefix('collection')->group(function () {

        // Area
        Route::get('area',[CollectionAreaController::class,'index'])->name('collection_area.all');
        Route::get('area/add', [CollectionAreaController::class,'add'])->name('collection_area.add');
        Route::post('area/add', [CollectionAreaController::class,'addPost']);
        Route::get('area/edit/{area}', [CollectionAreaController::class,'edit'])->name('collection_area.edit');
        Route::post('area/edit/{area}', [CollectionAreaController::class,'editPost']);
        Route::get('area/datatable', [CollectionAreaController::class,'datatable'])->name('collection_area.datatable');

        // Type
        Route::get('type',[CollectionTypeController::class,'index'])->name('collection_type.all');
        Route::get('type/add', [CollectionTypeController::class,'add'])->name('collection_type.add');
        Route::post('type/add', [CollectionTypeController::class,'addPost']);
        Route::get('type/edit/{type}', [CollectionTypeController::class,'edit'])->name('collection_type.edit');
        Route::post('type/edit/{type}', [CollectionTypeController::class,'editPost']);
        Route::get('type/datatable', [CollectionTypeController::class,'datatable'])->name('collection_type.datatable');

        // Sub Type
        Route::get('sub-type',[CollectionSubTypeController::class,'index'])->name('collection_sub_type.all');
        Route::get('sub-type/add', [CollectionSubTypeController::class,'add'])->name('collection_sub_type.add');
        Route::post('sub-type/add', [CollectionSubTypeController::class,'addPost']);
        Route::get('sub-type/edit/{subType}', [CollectionSubTypeController::class,'edit'])->name('collection_sub_type.edit');
        Route::post('sub-type/edit/{subType}', [CollectionSubTypeController::class,'editPost']);
        Route::get('sub-type/datatable', [CollectionSubTypeController::class,'datatable'])->name('collection_sub_type.datatable');
        // Collection
        Route::get('collection-receipt-print/{collection}',[CollectionController::class,'receiptPrint'])->name('collection.receipt_print');
        Route::get('collection-datatable',[CollectionController::class,'datatable'])->name('collection.datatable');
        Route::get('collection',[CollectionController::class,'index'])->name('collection.all');

        Route::get('collection/add', [CollectionController::class,'add'])->name('collection.add');
        Route::post('collection/add', [CollectionController::class,'addPost']);

        Route::get('collection/edit/{collection}', [CollectionController::class,'edit'])->name('collection.edit');
        Route::post('collection/update/{collection}', [CollectionController::class,'editPost'])->name('collection.update');

        Route::post('user_pin_check', [CollectionController::class,'userPinCheck'])->name('collection.user_pin_check');
        Route::get('get_sub_type', [CollectionController::class,'getSubType'])->name('collection.get_sub_type');
        Route::get('get_fees', [CollectionController::class,'getFees'])->name('collection.get_fees');

        //closing
        Route::get('collection-closing-datatable',[CollectionController::class,'closingDatatable'])->name('collection_closing.datatable');
        Route::get('collection-closing',[CollectionController::class,'closing'])->name('collection.closing');
        Route::post('collection-closing',[CollectionController::class,'closingPost']);
        Route::post('collection-closing/approve',[CollectionController::class,'closingApprove'])->name('collection.cashier_approve');
        Route::post('collection-closing/delete',[CollectionController::class,'closingDelete'])->name('collection.user_pin_check_closing_delete');

        //Reports
        Route::get('report/collection-summary',[CollectionReportController::class,'summary'])->name('collection.report.summary');
        Route::get('report/collection',[CollectionReportController::class,'collection'])->name('collection.report.collection');
        Route::get('report/collection-user-log',[CollectionReportController::class,'userLog'])->name('collection.report.user_log');
    });
    Route::middleware(['role:'.Role::$AUTO_RICKSHAW])->prefix('auto-rickshaw')->group(function () {
        Route::get('type',[AutoRickshawTypeController::class,'index'])->name('auto_rickshaw.type');
        Route::get('type-add',[AutoRickshawTypeController::class,'add'])->name('auto_rickshaw.type.add');
        Route::post('type-add',[AutoRickshawTypeController::class,'addPost']);
        Route::get('type-edit/{type}',[AutoRickshawTypeController::class,'edit'])->name('auto_rickshaw.type.edit');
        Route::post('type-edit/{type}',[AutoRickshawTypeController::class,'editPost']);
        Route::get('get-type-details',[AutoRickshawTypeController::class,'getTypeDetails'])->name('auto_rickshaw.get_type_details');

        Route::get('vehicle-license', [AutoRickshawHomeController::class,'vehicleLicense'])->name('auto_rickshaw.vehicle_license');
        Route::post('vehicle-license', [AutoRickshawHomeController::class,'vehicleLicensePost']);
        Route::get('vehicle-license-edit/{driverLicense}', [AutoRickshawHomeController::class,'vehicleLicenseEdit'])->name('auto_rickshaw.vehicle_edit');
        Route::post('vehicle-license-edit/{driverLicense}', [AutoRickshawHomeController::class,'vehicleLicenseEditPost']);
        Route::get('all-vehicle-license', [AutoRickshawHomeController::class,'allVehicleLicense'])->name('auto_rickshaw.all_vehicle_license');
        Route::get('vehicle-license-datatable', [AutoRickshawHomeController::class,'vehicleLicenseDatatable'])->name('auto_rickshaw.vehicle_license_datatable');
        Route::get('driving-license-print/{driverLicense}', [AutoRickshawHomeController::class,'vehicleLicensePrint'])->name('auto_rickshaw.vehicle_print');


        Route::get('owner-license', [AutoRickshawHomeController::class,'ownerLicense'])->name('auto_rickshaw.add_owner_license');
        Route::post('owner-license', [AutoRickshawHomeController::class,'ownerLicensePost']);
        Route::get('owner-license-edit/{ownerLicense}', [AutoRickshawHomeController::class,'ownerLicenseEdit'])->name('auto_rickshaw.owner_license_edit');
        Route::post('owner-license-edit/{ownerLicense}', [AutoRickshawHomeController::class,'ownerLicenseEditPost']);
        Route::get('all-owner-license', [AutoRickshawHomeController::class,'allOwnerLicense'])->name('auto_rickshaw.all_owner_license');
        Route::get('owner-license-datatable', [AutoRickshawHomeController::class,'ownerLicenseDatatable'])->name('auto_rickshaw.owner_license_datatable');
        Route::get('owner-license-print/{ownerLicense}', [AutoRickshawHomeController::class,'ownerLicensePrint'])->name('auto_rickshaw.owner_print');


        Route::get('report/vehicle-license', [AutoRickshawHomeController::class,'vehicleLicenseReport'])->name('auto_rickshaw.report_vehicle_license');
        Route::get('report/owner-license', [AutoRickshawHomeController::class,'ownerLicenseReport'])->name('auto_rickshaw.report_owner_license');

        Route::get('report/vehicle-license-collection', [AutoRickshawHomeController::class,'vehicleLicenseCollectionReport'])->name('auto_rickshaw.report_vehicle_license_collection');
        Route::get('report/owner-license-collection', [AutoRickshawHomeController::class,'ownerLicenseCollectionReport'])->name('auto_rickshaw.report_owner_license_collection');

    });

});

require __DIR__ . '/auth.php';

Route::get('cache', function () {
    Artisan::call('cache:forget spatie.permission.cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
//    Artisan::call('storage:link');
    return "Cleared!";
});
