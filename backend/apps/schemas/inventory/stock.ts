import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose'
import { MasterItemJoin } from '@schemas/master/master.item'
import { MasterItemBatchJoin } from '@schemas/master/master.item.batch'
import { MasterStockPointJoin } from '@schemas/master/master.stock.point'
import { HydratedDocument, SchemaTypes } from 'mongoose'

import { IMasterItem } from '../../interfaces/master.item'
import { IMasterItemBatch } from '../../interfaces/master.item.batch'
import { IMasterStockPoint } from '../../interfaces/master.stock.point'

export type InventoryStockDocument = HydratedDocument<InventoryStock>
@Schema({ collection: 'inventory_stock' })
export class InventoryStock {
  @Prop(MasterItemJoin)
  item: IMasterItem

  @Prop(MasterItemBatchJoin)
  batch: IMasterItemBatch

  @Prop(MasterStockPointJoin)
  stock_point: IMasterStockPoint

  @Prop({ type: SchemaTypes.Number })
  qty: number

  @Prop({ type: SchemaTypes.String })
  storing_label: string
}
export const InventoryStockSchema = SchemaFactory.createForClass(InventoryStock)
