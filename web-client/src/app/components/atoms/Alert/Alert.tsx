import { ReactElementLike } from 'prop-types'
import cn from 'classnames'

export interface AlertProps {
  label: string
  type: 'error' | 'warning' | 'success' | 'info'
  children?: ReactElementLike
}

export const Alert = ({ label, type = 'info', children }: AlertProps) => {
  return (
    <div
      className={cn(
        'alert shadow-lg',
        { 'alert-error': type === 'error' },
        { 'alert-info': type === 'info' },
        { 'alert-warning': type === 'warning' },
        { 'alert-success': type === 'success' }
      )}
    >
      <div>
        {children}
        <span>{label}</span>
      </div>
    </div>
  )
}
