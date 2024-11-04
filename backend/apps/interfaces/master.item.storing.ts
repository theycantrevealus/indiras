import { IMasterStockPoint } from './master.stock.point'

export interface IMasterItemStoring {
  stock_point: IMasterStockPoint
  storing_label: string
  minimum: number
  maximum: number
}
