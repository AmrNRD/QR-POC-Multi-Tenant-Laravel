<?php
namespace App\Common\Commands;

use App\Domain\Admin\Entities\Admin;
use App\Domain\Admin\Repositories\Contracts\AdminRepository;
use App\Domain\Admin\Repositories\Contracts\RoleRepository;
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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CreateTenant extends Command
{
    protected $signature = 'tenant:create {company} {admin}';
    protected $description = 'Creates a tenant with the company and admin';

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
     * @var RoleRepository
     */
    protected RoleRepository $roleRepository;


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
        $dns_successful=$this->registerDNSForTenantAccount($website);

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
     * @param string $company_slug
     * @param Website $website
     * @return Hostname
     */
    private function createHostname(string $company_slug,Website $website): Hostname
    {
        $hostname = new Hostname;
        $baseUrl = env('APP_BASE_URL');
        $hostname->fqdn = "{$company_slug}.{$baseUrl}";
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
        $user=$this->userRepository->create(['name' => $admin->name, 'email' => $admin->email, 'password' => $admin->password],false);
        $role=$this->roleRepository->findWhere(["slug"=>'super_admin'])->first();
        $user->roles()->attach($role);
        return $user;
    }


    /**
     * @param Admin $admin
     * @param Website $website
     * @return  bool
     */
    private function registerDNSForTenantAccount(Website $website):bool
    {
        $baseUrl = env('APP_BASE_URL');
        $response = Http::withHeaders([
            'X-Auth-Email'=>env('DNS_X_AUTH_EMAIL'),
            'X-Auth-Key'=>env('DNS_X_AUTH_KEY'),
            'Content-Type'=>'application/json',
        ])->post('https://api.cloudflare.com/client/v4/zones/'.env('DNS_ZONE_ID').'/dns_records', [
            'type' => 'A',
            'name' => $website->company->slug.".".$baseUrl,
            'content' => "94.237.100.175",
            'tls'=>120,
            'proxied'=>false
        ]);

        return  $response->successful();
    }


    /**
     * @param Admin $admin
     * @param Company $company
     * @return Website
     */
    private function registerTenant(Admin $admin,Company $company):Website
    {
        $website = $this->createWebsite($admin->id,$company->id);
        $hostname = $this->createHostname($company->slug,$website);
        return $website;
    }

}
