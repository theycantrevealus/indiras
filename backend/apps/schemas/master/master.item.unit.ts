import { IAccountCreatedBy } from '@gateway_core/account/interface/account.create_by'
import { IMasterItemUnit } from '@interfaces/master.item.unit'
import { Prop, raw, Schema, SchemaFactory } from '@nestjs/mongoose'
import { AccountJoin } from '@schemas/account/account.raw'
import { HydratedDocument, SchemaTypes } from 'mongoose'

export const MasterItemUnitJoin = raw({
  id: { type: String },
  code: { type: String },
  name: { type: String },
})

export type MasterItemUnitDocument = HydratedDocument<MasterItemUnit>

@Schema({ collection: 'master_item_unit' })
export class MasterItemUnit {
  @Prop({ type: SchemaTypes.String, unique: true })
  id: string

  @Prop({ type: SchemaTypes.String, required: true, unique: true })
  code: string

  @Prop({ type: SchemaTypes.String, required: true })
  name: string

  @Prop({ type: SchemaTypes.String })
  remark: string

  @Prop(AccountJoin)
  created_by: IAccountCreatedBy

  @Prop({
    type: SchemaTypes.Date,
    default: new Date(),
    required: true,
  })
  created_at: Date

  @Prop({
    type: SchemaTypes.Date,
    default: new Date(),
    required: true,
  })
  updated_at: Date

  @Prop({ type: SchemaTypes.Mixed, default: null })
  deleted_at: Date | null
}

export const MasterItemUnitSchema = SchemaFactory.createForClass(MasterItemUnit)

export interface IMasterItemUnitConversion {
  unit: IMasterItemUnit
  type: string
  allow_sell: boolean
  ratio: number
}

export const MasterItemUnitConversion = raw({
  unit: { type: MasterItemUnitJoin, _id: false },
  type: { type: String },
  allow_sell: { type: Boolean },
  ratio: { type: Number, example: 0.5 },
})
