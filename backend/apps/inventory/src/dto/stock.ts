import { IMasterItem } from '../../../interfaces/master.item'
import { IMasterItemBatch } from '../../../interfaces/master.item.batch'
import { IMasterStockPoint } from '../../../interfaces/master.stock.point'

export class StockDTO {
  item: IMasterItem
  batch: IMasterItemBatch
  stockPointOrigin: IMasterStockPoint
  stockPointTarget: IMasterStockPoint
  qty: number
  type: string
  transaction: string
  transactionId: string
}
