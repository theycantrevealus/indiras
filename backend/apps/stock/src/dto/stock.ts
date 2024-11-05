import { CMasterItem } from '@gateway_core/master/dto/master.item'
import { CMasterStockPoint } from '@gateway_core/master/dto/master.stock.point'
import { ApiProperty } from '@nestjs/swagger'
import { CMasterItemBatch } from '@schemas/master/master.item.batch'
import { IsNotEmpty, IsNumber } from 'class-validator'

import { IMasterItem } from '../../../interfaces/master.item'
import { IMasterItemBatch } from '../../../interfaces/master.item.batch'
import { IMasterStockPoint } from '../../../interfaces/master.stock.point'

export class StockDTO {
  @ApiProperty({
    type: CMasterItem,
    required: true,
  })
  item: IMasterItem

  @ApiProperty({
    type: CMasterItemBatch,
    required: true,
  })
  batch: IMasterItemBatch

  @ApiProperty({
    type: CMasterStockPoint,
    required: true,
  })
  stock_point: IMasterStockPoint

  @ApiProperty({
    example: 0,
    description: 'Item quantity',
    required: false,
    default: 0,
  })
  @IsNotEmpty()
  @IsNumber()
  qty?: number
}
