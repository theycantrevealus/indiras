import { IMasterItemBrand } from './master.item.brand'

export interface IMasterItem {
  id: string
  code: string
  name: string
  brand: IMasterItemBrand
}
