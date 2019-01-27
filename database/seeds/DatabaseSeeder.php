<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		/*
        Model::unguard();
        $this->call(UserTableSeeder::class);
		Model::reguard();
		 */
		$this->call(SproductTableSeeder::class);
		$this->call(ProductTableSeeder1::class);
		$this->call(PorderTableSeeder::class);
		$this->call(OrderproductTableSeeder::class);
		$this->call(CourierTableSeeder::class);
		$this->call(CityTableSeeder::class);
		$this->call(CategoryTableSeeder::class);
		$this->call(CountryTableSeeder::class);
		$this->call(StateTableSeeder::class);
		$this->call(BrandTableSeeder::class);
		$this->call(TeamTableSeeder::class);
		$this->call(MerchantTable1Seeder::class);
		$this->call(MerchantCategoryTableSeeder::class);
		$this->call(StationsProductTableSeeder::class);
		$this->call(MerchantProductTableSeeder::class);
		$this->call(CurrencyTableSeeder::class);
		$this->call(MerchantBrandTableSeeder::class);
		$this->call(UserTableSeeder::class);
		$this->call(OrderTableSeeder::class);
		$this->call(PaymentSeeder::class);
		$this->call(StaffTableSeeder::class);
		$this->call(RolesTableSeeder::class);
		$this->call(RoleUsersSeeder::class);
		$this->call(StationProductTableSeeder::class);
		$this->call(GlobalTableSeeder::class);
		$this->call(SubcatLevel2Seeder_C10::class);
// 		$this->call(OccupationTableSeeder::class);
//		$this->call(SubcatLevel1Seeder_C1::class);
//		$this->call(SubcatLevel1Seeder_C2::class);
//		$this->call(SubcatLevel1Seeder_C3::class);
//		  $this->call(SubcatLevel1Seeder_C4::class);
//		 $this->call(SubcatLevel1Seeder_C5::class);
//		 $this->call(SubcatLevel1Seeder_C6::class);
//		 $this->call(SubcatLevel1Seeder_C7::class);
//		 $this->call(SubcatLevel1Seeder_C8::class);
//		 $this->call(SubcatLevel1Seeder_C9::class);
//		 $this->call(SubcatLevel1Seeder_C10::class);
//		 $this->call(SubcatLevel2Seeder_C10::class);
//		$this->call(DirectorySeeder::class);
//		$this->call(AdslotTableSeeder::class);
//		$this->call(AdslotproductTableSeeder::class);
//		$this->call(CertificateTableSeeder::class);
//		$this->call(DescimageTableSeeder::class);
//		$this->call(VBannerTableSeeder::class);
//		$this->call(SignboardTableSeeder::class);
//		$this->call(AlbumTableSeeder::class);
//		$this->call(ProfileTableSeeder::class);
//		$this->call(ProductKleensoTableSeeder::class);
//		$this->call(ProductTableSeeder2::class);
//		$this->call(ProductBuildingTableSeeder::class);
//		$this->call(StationTableSeeder2::class);
//		$this->call(LanguageTableSeeder::class);


//		$this->call(ProductSpecTableSeeder::class);
//		$this->call(SpecificationTableSeeder::class);
//		$this->call(ProductDealerTableSeeder::class);
//		$this->call(WholesaleTableSeeder::class);
//		$this->call(BuntingTableSeeder::class);
//		$this->call(AddressTableSeeder::class);
//		$this->call(BankTableSeeder::class);
//		$this->call(BankaccountTableSeeder::class);
//		$this->call(DirectorTableSeeder::class);
//		$this->call(BuyerTableSeeder::class);


//		//$this->call(MerchantTableSeeder2::class);


//		 $this->call(UserTableSeeder1::class);
//		$this->call(MerchantCategoryTableSeeder::class);
//		$this->call(DocumentTableSeeder::class);
//		$this->call(DirectorDocumentTableSeeder::class);
//
//		$this->call(ProductTableSeeder3::class);
//
//		$this->call(DealerTableSeeder::class);


//		$this->call(OpenWishSeeder::class);
//		$this->call(SpecificationSeeder::class);
//		$this->call(AutolinkSeeder::class);

//		//$this->call(OrderRandomSeeder::class);
//
//		// SQLSTATE[42S22]: Column not found: 1054 Unknown column
//		// 'productdealer.deleted' in 'field list'
//		//$this->call(ProductHitSeeder::class);
//

//		$this->call(StationTableSeeder::class);
//		$this->call(StationCategoryTableSeeder::class);
//		$this->call(StationBrandTableSeeder::class);
//		// $this->call(OwarehouseTableSeeder::class);
//		$this->call(OwarehousepledgeTableSeeder::class);
//		$this->call(OcbcHeaderTableSeeder::class);
//		$this->call(OcbcInvTableSeeder::class);
//		$this->call(OcbcTrailerTableSeeder::class);
//		$this->call(OcbcDetailTableSeeder::class);
//		$this->call(ReceiptSeeder::class);
//		$this->call(DeliveryOrdersSeeder::class);
//		$this->call(OcbcPaymentStatusSeeder::class);
//		$this->call(PositionTableSeeder::class);
//		$this->call(EmployeeTableSeeder::class);
//		$this->call(OrderproductTableSeeder::class);

//		//$this->call(OshopSectionTableSeeder::class);
//		$this->call(AreaTableSeeder::class);
//		$this->call(OshopProductTableSeeder::class);
//		// $this->call(CrereasonsTableSeeder::class); //Doesn't exists error ~Zurez
//
//		// $this->call(VoucherTableSeeder::class); //Doesn't exists error ~Zurez Update:: Has this error been fixed?
//		$this->call(PCBTableSeeder::class);
//		$this->call(PCBGlobalTableSeeder::class);
//		$this->call(PCBTableTableSeeder::class);
//
//
//		$this->call(VoucherTableSeeder::class);
//		$this->call(TimeSlotTableSeeder::class);
//
//		$this->call(MerchantTableSeederFee::class);
//		$this->call(ProductTableSeederFee::class);
//
//        $this->call(SocialMediaTableSeeder::class);



	}
}
