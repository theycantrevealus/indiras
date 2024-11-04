import { IMasterStockPoint } from '../../../../../interfaces/master.stock.point'

export interface IAccountCreatedBy {
  id: string
  email: string
  first_name: string
  last_name: string
  stock_point?: IMasterStockPoint[]
}
