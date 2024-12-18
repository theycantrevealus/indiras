import { IAccountCreatedBy } from '@gateway_core/account/interface/account.create_by'
import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose'
import { AccountJoin } from '@schemas/account/account.raw'
import { MasterQueueJoin } from '@schemas/master/master.queue.machine'
import { HydratedDocument, SchemaTypes } from 'mongoose'

import { IMasterQueue } from '../../../../../../interfaces/master.queue'

export type OperationQueueDocument = HydratedDocument<OperationQueue>
@Schema({ collection: 'operation_queue' })
export class OperationQueue {
  @Prop({ type: SchemaTypes.String, unique: true })
  id: string

  @Prop(MasterQueueJoin)
  machine: IMasterQueue

  @Prop({ type: SchemaTypes.Number })
  queue_number: string

  @Prop(AccountJoin)
  created_by: IAccountCreatedBy

  @Prop({
    type: SchemaTypes.Date,
    default: () => new Date(),
    required: true,
  })
  created_at: Date

  @Prop({
    type: SchemaTypes.Date,
    default: () => new Date(),
    required: true,
  })
  updated_at: Date

  @Prop({ type: SchemaTypes.Mixed, default: null })
  deleted_at: Date | null
}

export const OperationQueueSchema = SchemaFactory.createForClass(OperationQueue)
