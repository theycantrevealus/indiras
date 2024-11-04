import { QueueMasterData } from '@configuration/queue'
import { AccountModule } from '@gateway_core/account/account.module'
import { MasterDepartmentController } from '@gateway_core/master/controllers/master.department.controller'
import { MasterItemBrandController } from '@gateway_core/master/controllers/master.item.brand.controller'
import { MasterItemCategoryController } from '@gateway_core/master/controllers/master.item.category.controller'
import { MasterItemController } from '@gateway_core/master/controllers/master.item.controller'
import { MasterItemSupplierController } from '@gateway_core/master/controllers/master.item.supplier.controller'
import { MasterItemUnitController } from '@gateway_core/master/controllers/master.item.unit.controller'
import { MasterStockPointController } from '@gateway_core/master/controllers/master.stock.point.controller'
import { MasterDepartmentService } from '@gateway_core/master/services/master.department.service'
import { MasterItemBrandService } from '@gateway_core/master/services/master.item.brand.service'
import { MasterItemCategoryService } from '@gateway_core/master/services/master.item.category.service'
import { MasterItemService } from '@gateway_core/master/services/master.item.service'
import { MasterItemSupplierService } from '@gateway_core/master/services/master.item.supplier.service'
import { MasterItemUnitService } from '@gateway_core/master/services/master.item.unit.service'
import { MasterStockPointService } from '@gateway_core/master/services/master.stock.point.service'
import { LogActivity, LogActivitySchema } from '@log/schemas/log.activity'
import { LogLogin, LogLoginSchema } from '@log/schemas/log.login'
import { BullModule } from '@nestjs/bullmq'
import { Module } from '@nestjs/common'
import { MongooseModule } from '@nestjs/mongoose'
import {
  MasterDepartment,
  MasterDepartmentSchema,
} from '@schemas/master/master.department'
import { MongoMiddlewareMasterDepartment } from '@schemas/master/master.department.middleware'
import { MasterItem, MasterItemSchema } from '@schemas/master/master.item'
import {
  MasterItemBrand,
  MasterItemBrandSchema,
} from '@schemas/master/master.item.brand'
import { MongoMiddlewareMasterItemBrand } from '@schemas/master/master.item.brand.middleware'
import {
  MasterItemCategory,
  MasterItemCategorySchema,
} from '@schemas/master/master.item.category'
import { MongoMiddlewareMasterItemCategory } from '@schemas/master/master.item.category.middleware'
import { MongoMiddlewareMasterItem } from '@schemas/master/master.item.middleware'
import {
  MasterItemSupplier,
  MasterItemSupplierSchema,
} from '@schemas/master/master.item.supplier'
import { MongoMiddlewareMasterItemSupplier } from '@schemas/master/master.item.supplier.middleware'
import {
  MasterItemUnit,
  MasterItemUnitSchema,
} from '@schemas/master/master.item.unit'
import { MongoMiddlewareMasterItemUnit } from '@schemas/master/master.item.unit.middleware'
import {
  MasterStockPoint,
  MasterStockPointSchema,
} from '@schemas/master/master.stock.point'
import { MongoMiddlewareMasterStockPoint } from '@schemas/master/master.stock.point.middleware'
import { AuthModule } from '@security/auth.module'

@Module({
  imports: [
    MongooseModule.forFeature(
      [
        { name: MasterStockPoint.name, schema: MasterStockPointSchema },
        { name: MasterItemSupplier.name, schema: MasterItemSupplierSchema },
        { name: MasterItemBrand.name, schema: MasterItemBrandSchema },
        { name: MasterItemUnit.name, schema: MasterItemUnitSchema },
        { name: MasterItemCategory.name, schema: MasterItemCategorySchema },
        { name: MasterItem.name, schema: MasterItemSchema },
        { name: MasterDepartment.name, schema: MasterDepartmentSchema },
        { name: LogLogin.name, schema: LogLoginSchema },
        { name: LogActivity.name, schema: LogActivitySchema },
      ],
      'primary'
    ),
    BullModule.registerQueueAsync(QueueMasterData),
    AuthModule,
    AccountModule,
  ],
  controllers: [
    MasterItemSupplierController,
    MasterItemBrandController,
    MasterItemCategoryController,
    MasterStockPointController,
    MasterItemUnitController,
    MasterItemController,
    MasterDepartmentController,
  ],
  providers: [
    MongoMiddlewareMasterStockPoint,
    MongoMiddlewareMasterItemSupplier,
    MongoMiddlewareMasterItemBrand,
    MongoMiddlewareMasterItemUnit,
    MongoMiddlewareMasterItemCategory,
    MongoMiddlewareMasterItem,

    MongoMiddlewareMasterDepartment,

    MasterDepartmentService,
    MasterItemSupplierService,
    MasterItemBrandService,
    MasterItemCategoryService,
    MasterStockPointService,
    MasterItemUnitService,
    MasterItemService,
  ],
  exports: [
    MasterDepartmentService,
    MasterItemSupplierService,
    MasterItemBrandService,
    MasterItemCategoryService,
    MasterStockPointService,
    MasterItemUnitService,
    MasterItemService,
  ],
})
export class MasterModule {}
