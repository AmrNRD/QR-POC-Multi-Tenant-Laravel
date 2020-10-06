<?php
namespace App\Common\Commands;

use App\Domain\Admin\Entities\Admin;
use App\Domain\Admin\Repositories\Contracts\AdminRepository;
use App\Domain\Company\Entities\Company;
use App\Domain\Company\Repositories\Contracts\CompanyRepository;
use App\Domain\Tenant\User\Entities\User;
use App\Domain\Tenant\User\Repositories\Contracts\UserRepository;
use App\Infrastructure\TenancyModels\Hostname;
use App\Infrastructure\TenancyModels\Website;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Environment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateTenant extends Command
{
    protected $signature = 'tenant:create {company} {admin}';
    protected $description = 'Creates a tenant with the provided name and email address e.g. php artisan tenant:create boise boise@example.com';

    /**
     * @var AdminRepository
     */
    protected AdminRepository $adminRepository;

    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * @var CompanyRepository
     */
    protected CompanyRepository $companyRepository;


    /**
     * CreateTenant constructor.
     * @param AdminRepository $adminRepository
     * @param UserRepository $userRepository
     * @param CompanyRepository $companyRepository
     */
    public function __construct(AdminRepository $adminRepository, UserRepository $userRepository,CompanyRepository $companyRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->userRepository = $userRepository;
        $this->companyRepository=$companyRepository;
        parent::__construct();
    }


    /**
     *
     */
    public function handle()
    {
        $company_id = $this->argument('company');
        $admin_id = $this->argument('admin');

        $company=$this->getCompany($company_id);
        $admin=$this->getAdmin($admin_id);



        $website = $this->registerTenant($admin,$company);
        $this->createAdminTenantAccount($admin, $website);

        $this->info("Tenant '{$company->name}' is created and is now accessible at {$website->hostnames()->first()->fqdn}");
        $this->info("Admin {$admin->name} can log in using his password password");
    }


    /**
     * @param int $company_id
     * @return Company
     */
    private  function  getCompany(int $company_id):Company
    {
     return  $this->companyRepository->findWhere(["id"=>$company_id])->first();
    }


    /**
     * @param int $admin_id
     * @return Admin
     */
    private  function  getAdmin(int $admin_id):Admin
    {
        return  $this->adminRepository->findWhere(["id"=>$admin_id])->first();
    }


    /**
     * @param int $admin_id
     * @param int $company_id
     * @return Website
     */
    private function createWebsite(int $admin_id,int $company_id): Website
    {
        $website = new Website;
        app(WebsiteRepository::class)->create($website);
        $website->admin_id = $admin_id;
        $website->company_id = $company_id;
        $website->save();
        return $website;
    }

    /**
     * @param string $company_name
     * @param Website $website
     * @return Hostname
     */
    private function createHostname(string $company_name,Website $website): Hostname
    {
        $hostname = new Hostname;
        $baseUrl = env('APP_BASE_URL');
        $hostname->fqdn = "{$company_name}.{$baseUrl}";
        $hostname->id = (string)Str::uuid();
        app(HostnameRepository::class)->attach($hostname, $website);
        $hostname->website_id = $website->id;
        $hostname->save();
        return $hostname;
    }


    /**
     * @param Admin $admin
     * @param Website $website
     * @return User
     */
    private function createAdminTenantAccount(Admin $admin,Website $website):User
    {
        app(Environment::class)->tenant($website);
        return $this->userRepository->create(['name' => $admin->name, 'email' => $admin->email, 'password' => $admin->password]);
    }


    /**
     * @param Admin $admin
     * @param Company $company
     * @return Website
     */
    private function registerTenant(Admin $admin,Company $company):Website
    {
        $website = $this->createWebsite($admin->id,$company->id);
        $hostname = $this->createHostname($company->name,$website);
        return $website;
    }

}
